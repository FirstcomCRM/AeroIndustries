<?php

namespace backend\controllers;

use Yii;
use common\models\GeneralPo;
use common\models\SearchGeneralPo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\BaseUrl;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\GeneralPoDetail;
use common\models\GeneralPoPayment;
use common\models\Setting;
use common\models\GpoSupplier;
use common\models\CurrencyConverter;
use common\models\Unit;
use common\models\Part;

/**
 * GeneralPoController implements the CRUD actions for GeneralPo model.
 */
class GeneralPoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');

        foreach ( $userGroupArray as $uGId => $uGName ){
            $permission = UserPermission::find()->where(['controller' => 'GeneralPo'])->andWhere(['user_group_id' => $uGId ] )->all();
            $actionArray = [];
            foreach ( $permission as $p )  {
                $actionArray[] = $p->action;
            }

            $allow[$uGName] = false;
            $action[$uGName] = $actionArray;
            if ( ! empty( $action[$uGName] ) ) {
                $allow[$uGName] = true;
            }

        }
        return [
            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    [
                        'actions' => $action['admin'],
                        'allow' => $allow['admin'],
                        'roles' => ['admin'],
                    ],

                    [
                        'actions' => $action['engineer'],
                        'allow' => $allow['engineer'],
                        'roles' => ['engineer'],
                    ],
                    [
                        'actions' => $action['mechanic'],
                        'allow' => $allow['mechanic'],
                        'roles' => ['mechanic'],
                    ],
                    [
                        'actions' => $action['purchasing'],
                        'allow' => $allow['purchasing'],
                        'roles' => ['purchasing'],
                    ],
                    [
                        'actions' => $action['quality'],
                        'allow' => $allow['quality'],
                        'roles' => ['quality'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all GeneralPo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchGeneralPo();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Finds the GeneralPo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GeneralPo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GeneralPo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    /**
     * Creates a new GeneralPo .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew()
    {
        $model = new GeneralPo();
        $detail = new GeneralPoDetail();

        $firstSupplier = GpoSupplier::find()->one();
        $supplierAddresses = array();
        $supplierAttention = '';
        if ( $firstSupplier ) {
            $supplierAddresses[$firstSupplier->p_addr_1] = $firstSupplier->p_addr_1;
            $supplierAddresses[$firstSupplier->p_addr_2] = $firstSupplier->p_addr_2;
            $supplierAddresses[$firstSupplier->p_addr_3] = $firstSupplier->p_addr_3;
            $supplierAttention = $firstSupplier->contact_person;
        }

        if ($model->load(Yii::$app->request->post()) ) {
            // d(Yii::$app->request->post());exit;

            /* save user involved */
            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;

            /* save total */
            // $model->subtotal = $currentDateTime;

            /* continue the previous po number */
            $model->purchase_order_no = 1;
            $ppo = GeneralPo::find()->where(['<>','deleted', 1])->orderBy('purchase_order_no DESC')->limit(1)->one();
            if ( !empty ( $ppo ) ) {
                $previousNo = $ppo->purchase_order_no;
                $model->purchase_order_no = $previousNo+1;
            }
            if ( $model->save() ) {
                $generalPOId = $model->id;
                if ( $detail->load(Yii::$app->request->post()) ) {
                    foreach ( Yii::$app->request->post()['GeneralPoDetail'] as $d ) {
                        $poD = new GeneralPoDetail();
                        $poD->general_po_id = $generalPOId;
                        $poD->part_id = $d['part_id'];
                        $poD->unit_id = $d['unit_id'];
                        $poD->quantity = $d['quantity'];
                        $poD->unit_price = $d['unit_price'];
                        $poD->subtotal = $d['subTotal'];
                        $poD->save();
                    }
                }
                $this->composeEmail($model);
                Yii::$app->getSession()->setFlash('success', 'Purchase order created!');
                return $this->redirect(['preview', 'id' => $model->id]);
            } /* save model */ else {
                Yii::$app->getSession()->setFlash('danger', 'Unable to create purchase order!');
            }


        }
        return $this->render('new', [
            'model' => $model,
            'detail' => $detail,
            'supplierAttention' => $supplierAttention,
            'supplierAddresses' => $supplierAddresses,
        ]);
    }

    /**
     * Edit an existing GeneralPo .
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $model = GeneralPo::getGeneralPo($id);
        $detail = new GeneralPoDetail();
        $oldDetail = GeneralPoDetail::getGeneralPoDetail($id);
        $supplierId = $model->supplier_id;
        //$firstSupplier = GpoSupplier::getSupplier($supplierId);
        $firstSupplier = GpoSupplier::find()->where(['id'=>$supplierId]);
        $supplierAddresses = array();
        $supplierAttention = '';
        if ( $firstSupplier ) {
            $supplierAddresses[$firstSupplier->p_addr_1] = $firstSupplier->p_addr_1;
            $supplierAddresses[$firstSupplier->p_addr_2] = $firstSupplier->p_addr_2;
            $supplierAddresses[$firstSupplier->p_addr_3] = $firstSupplier->p_addr_3;
            $supplierAttention = $firstSupplier->contact_person;
        }

        if ($model->load(Yii::$app->request->post()) ) {
            // d(Yii::$app->request->post());exit;
            /* save user involved */
            $model->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->updated = $currentDateTime;

            /* continue the previous po number */

            if ( $model->save() ) {
                $purchaseOrderId = $id;
                if ( $detail->load(Yii::$app->request->post()) ) {
                    GeneralPoDetail::deleteAll(['general_po_id' => $purchaseOrderId]);
                    foreach ( Yii::$app->request->post()['GeneralPoDetail'] as $d ) {
                        $poD = new GeneralPoDetail();
                        $poD->general_po_id = $purchaseOrderId;
                        $poD->part_id = $d['part_id'];
                        $poD->unit_id = $d['unit_id'];
                        $poD->quantity = $d['quantity'];
                        $poD->unit_price = $d['unit_price'];
                        $poD->subtotal = $d['subTotal'];
                        $poD->save();
                    }

                }


                Yii::$app->getSession()->setFlash('success', 'Purchase order updated!');
                return $this->redirect(['preview', 'id' => $model->id]);
            } /* save model */ else {
                Yii::$app->getSession()->setFlash('danger', 'Unable to create purchase order!');
            }


        }
        return $this->render('edit', [
            'model' => $model,
            'detail' => $detail,
            'oldDetail' => $oldDetail,
            'supplierAttention' => $supplierAttention,
            'supplierAddresses' => $supplierAddresses,
        ]);

    }

    /**
     * Displays a single GeneralPo .
     * @param integer $id
     * @return mixed
     */
    public function actionPreview($id)
    {
        $payment = new GeneralPoPayment();
        if ( $payment->load( Yii::$app->request->post() ) ) {
            // d(Yii::$app->request->post());exit;
            $po = PurchaseOrder::find()->where(['id' => $id])->one();

            $po->status = 0;
            if ( Yii::$app->request->post()['balanceAmt'] <= $payment->amount ) {
                $po->status = 1;
            } else if ( Yii::$app->request->post()['balanceAmt'] >= $payment->amount && $payment->amount > 0) {
                $po->status = 2;
            }
            $po->save();


            if ( $payment->save() ) {
                Yii::$app->getSession()->setFlash('success', 'Payment added!');
                return $this->redirect(['preview', 'id' => $id]);
            }
        }

        $oldPayment = false;
        if ( GeneralPoPayment::find()->where(['general_po_id' => $id])->exists() ) {
            $oldPayment = GeneralPoPayment::find()->where(['general_po_id' => $id])->andWhere(['<>', 'status', 0])->all();
        }


        return $this->render('preview', [
            'model' => $this->findModel($id),
            'payment' => $payment,
            'oldPayment' => $oldPayment,
            'detail' => GeneralPoDetail::find()->where(['general_po_id' => $id ])->all(),
        ]);
    }
    /**
     * Deletes an existing GeneralPo model by changing the delete status to 1 .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRemove($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'Customer deleted');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to delete Customer');
        }

        return $this->redirect(['index']);
    }

    /**
     * approve the po by changing 'approved' to 'approved'
     * @param integer $id
     * @return mixed
     */
    public function actionApprove($id)
    {
        // $this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->approved = 'approved';
        $model->status = 1;
        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'Purchase Order Approved');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to approve the Purchase Order');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * cancel the po by changing 'approved' to 'cancel'
     * @param integer $id
     * @return mixed
     */
    public function actionCancel($id)
    {
        // $this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->approved = 'cancelled';
        $model->status = 0;
        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'Purchase Order Cancelled');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to cancel the Purchase Order');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

      /**
     * print PO in the preview page
     * @param integer $id
     * @return mixed
     */
    public function actionPrint($id)
    {
        $this->layout = 'print';

        return $this->render('print', [
            'model' => $this->findModel($id),
            'detail' => GeneralPoDetail::find()->where(['general_po_id' => $id ])->all(),
        ]);
    }





    public function actionAjaxAddress()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $supplierId = Yii::$app->request->post()['supplierId'];
            print_r($supplierId);
            $supplier = GpoSupplier::find()->where(['id' => $supplierId])->one();
            return $this->render('ajax-address', [
                'supplier' => $supplier,
            ]);
        }
    }
    /**
     * Get attention based on supplier id selected.
     *
     */

    public function actionAjaxAttention()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $supplierId = Yii::$app->request->post()['supplierId'];
            $supplier = GpoSupplier::find()->where(['id' => $supplierId])->one();
            return $this->render('ajax-attention', [
                'supplier' => $supplier,
            ]);
        }
    }


    /**
* AJAX FUNCTION.
*/

    /**
     * Add parts
     *
     */
    public function actionAjaxPart()
    {
        $detail = new GeneralPoDetail();
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $n = Yii::$app->request->post()['n'];
            $partId = Yii::$app->request->post()['part'];
            $converted_unit = Yii::$app->request->post()['converted_unit'];
            $qty = Yii::$app->request->post()['qty'];
            $unit = Yii::$app->request->post()['unit'];
            $unitm = Yii::$app->request->post()['unitm'];
            $subTotal = Yii::$app->request->post()['subTotal'];

            $part = Part::find()->where(['id' => $partId])->one()->part_no;
            $unitM = Unit::find()->where(['id' => $unitm])->one();

            return $this->render('ajax-part', [
                'n' => $n,
                'qty' => $qty,
                'part' => $part,
                'partId' => $partId,
                'converted_unit' => $converted_unit,
                'unit' => $unit,
                'unitM' => $unitM,
                'subTotal' => $subTotal,
                'detail' => $detail,
            ]);
        }
    }



    /**
    *Protected Functions
    */
    protected function composeEmail($model){
      $data = Setting::find()->where(['name'=>'GPO Email Notification'])->one();
      $poNumber = GeneralPO::getGPONo($model->purchase_order_no,$model->created);
    //  $link = Html::a('Link',['purchase-order/preview','id'=>$model->id]);
    //  $link = 'http://www.aeroindustries3011.firstcomdemolinks.com/system88/backend/web/index.php?r=purchase-order%2Fpreview&id='.$model->id;
      $link = Html::a('Link', Url::to(['general-po/preview','id'=>$model->id], true));
      $message = '';
      $message .= "<p>GPO {$poNumber} has been created</p>";
      $message .= $link;
      $data = Yii::$app->mailer->compose()
      ->setTo($data->value)
    //    ->setTo('eumerjoseph.ramos@yahoo.com')
      ->setFrom(['info@aeriindustriesdemo.com' => 'info@aeriindustriesdemo.com'])
      ->setSubject('General PO Created')
      ->setHtmlBody($message)
      ->send();


    }


}
