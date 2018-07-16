<?php

namespace backend\controllers;

use Yii;
use common\models\ToolPo;
use common\models\SearchToolPo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\BaseUrl;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\ToolPoDetail;
use common\models\ToolPoPayment;
use common\models\Setting;
use common\models\Supplier;
use common\models\CurrencyConverter;
use common\models\Unit;
use common\models\Part;
use common\models\TpoAttachment;

/**
 * ToolPoController implements the CRUD actions for ToolPo model.
 */
class ToolPoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');

        foreach ( $userGroupArray as $uGId => $uGName ){
            $permission = UserPermission::find()->where(['controller' => 'ToolPo'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all ToolPo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchToolPo();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Finds the ToolPo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ToolPo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ToolPo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    /**
     * Creates a new ToolPo .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew()
    {
        $model = new ToolPo();
        $detail = new ToolPoDetail();
        $poAttachment = new TpoAttachment();
        $model->gst_rate = 7;

        $firstSupplier = Supplier::find()->one();
        $supplier_id = $firstSupplier->id;
        if ( isset(Yii::$app->request->get()['supplier_id']) ) {
            $supplier_id = Yii::$app->request->get()['supplier_id'];
            $firstSupplier = Supplier::find()->where(['id'=>$supplier_id])->one();
        }
        $supplierAddresses = array();
        $supplierAttention = '';
        if ( $firstSupplier ) {
            $supplierAddresses[$firstSupplier->p_addr_1] = $firstSupplier->p_addr_1;
            $supplierAddresses[$firstSupplier->p_addr_2] = $firstSupplier->p_addr_2;
            $supplierAddresses[$firstSupplier->p_addr_3] = $firstSupplier->p_addr_3;
            $supplierAttention = $firstSupplier->contact_person;
        } 

        $dataPartNonReuse = Part::dataToolStock($firstSupplier->id);

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
            $ppo = ToolPo::find()->where(['<>','deleted', 1])->orderBy('purchase_order_no DESC')->limit(1)->one();
            if ( !empty ( $ppo ) ) {
                $previousNo = $ppo->purchase_order_no;
                $model->purchase_order_no = $previousNo+1;
            }
            if ( $model->save() ) {
                $toolPOId = $model->id;
                if ( $detail->load(Yii::$app->request->post()) ) {
                    foreach ( Yii::$app->request->post()['ToolPoDetail'] as $d ) {
                        $poD = new ToolPoDetail();
                        $poD->tool_po_id = $toolPOId;
                        $poD->part_id = $d['part_id'];
                        $poD->unit_id = $d['unit_id'];
                        $poD->quantity = $d['quantity'];
                        $poD->unit_price = $d['unit_price'];
                        $poD->subtotal = $d['subTotal'];
                        $poD->save();
                    }
                }

                 if ( $poAttachment->load(Yii::$app->request->post()) ) {
                    $poAttachment->attachment = UploadedFile::getInstances($poAttachment, 'attachment');
                    foreach ($poAttachment->attachment as $file) {
                        $fileName = md5(date("YmdHis")).'-'.$file->name;
                        $qAttachmentClass = explode('\\', get_class($poAttachment))[2];
                        $file->saveAs('uploads/TpoAttachment/'.$fileName);
                        /* image upload */
                        $poA = new TpoAttachment();
                        $poA->type = 'po_attachment';
                        $poA->tool_po_id = $toolPOId;
                        $poA->value = $fileName;
                        $poA->save();
                    }
                }

                // $this->composeEmail($model);
                Yii::$app->getSession()->setFlash('success', 'Purchase order created!');
                return $this->redirect(['preview', 'id' => $model->id]);
            } /* save model */ else {
                Yii::$app->getSession()->setFlash('danger', 'Unable to create purchase order!');
            }


        }
        return $this->render('new', [
            'model' => $model,
            'supplier_id' => $supplier_id,
            'detail' => $detail,
            'supplierAttention' => $supplierAttention,
            'dataPartNonReuse' => $dataPartNonReuse,
            'supplierAddresses' => $supplierAddresses,
            'poAttachment' => $poAttachment,
        ]);
    }

    /**
     * Edit an existing ToolPo .
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $model = ToolPo::getToolPo($id);
        $detail = new ToolPoDetail();
        $oldDetail = ToolPoDetail::getToolPoDetail($id);
        $poAttachment = new TpoAttachment();
        $currAttachment = TpoAttachment::getTpoAttachment($id);
        $supplierId = $model->supplier_id;
        //$firstSupplier = TpoSupplier::getSupplier($supplierId);
        $firstSupplier = Supplier::find()->where(['id'=>$supplierId])->one();
        $supplierAddresses = array();
        $supplierAttention = '';
        if ( $firstSupplier ) {
            $supplierAddresses[$firstSupplier->p_addr_1] = $firstSupplier->p_addr_1;
            $supplierAddresses[$firstSupplier->p_addr_2] = $firstSupplier->p_addr_2;
            $supplierAddresses[$firstSupplier->p_addr_3] = $firstSupplier->p_addr_3;
            $supplierAttention = $firstSupplier->contact_person;
        }

        $dataPartNonReuse = Part::dataToolStock($firstSupplier->id);
        
        if ($model->load(Yii::$app->request->post()) ) {
            // d(Yii::$app->request->post());exit;
            /* save user involved */
            $model->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->updated = $currentDateTime;

            /* continue the previous po number */

            if ( $model->save() ) {
                $toolPOId = $id;
                if ( $detail->load(Yii::$app->request->post()) ) {
                    ToolPoDetail::deleteAll(['tool_po_id' => $toolPOId]);
                    foreach ( Yii::$app->request->post()['ToolPoDetail'] as $d ) {
                        $poD = new ToolPoDetail();
                        $poD->tool_po_id = $toolPOId;
                        $poD->part_id = $d['part_id'];
                        $poD->unit_id = $d['unit_id'];
                        $poD->quantity = $d['quantity'];
                        $poD->unit_price = $d['unit_price'];
                        $poD->subtotal = $d['subTotal'];
                        $poD->save();
                    }

                }

                 if ( $poAttachment->load(Yii::$app->request->post()) ) {
                    $poAttachment->attachment = UploadedFile::getInstances($poAttachment, 'attachment');
                    foreach ($poAttachment->attachment as $file) {
                        $fileName = md5(date("YmdHis")).'-'.$file->name;
                        $qAttachmentClass = explode('\\', get_class($poAttachment))[2];
                        $file->saveAs('uploads/TpoAttachment/'.$fileName);
                        /* image upload */
                        $poA = new TpoAttachment();
                        $poA->type = 'po_attachment';
                        $poA->tool_po_id = $toolPOId;
                        $poA->value = $fileName;
                        $poA->save();
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
            'supplier_id' => $supplierId,
            'detail' => $detail,
            'oldDetail' => $oldDetail,
            'supplierAttention' => $supplierAttention,
            'supplierAddresses' => $supplierAddresses,
            'currAttachment' => $currAttachment,
            'dataPartNonReuse' => $dataPartNonReuse,
            'poAttachment' => $poAttachment,
        ]);

    }

    /**
     * Displays a single ToolPo .
     * @param integer $id
     * @return mixed
     */
    public function actionPreview($id)
    {
        $payment = new ToolPoPayment();
        $currAttachment = TpoAttachment::getTpoAttachment($id);
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
        if ( ToolPoPayment::find()->where(['tool_po_id' => $id])->exists() ) {
            $oldPayment = ToolPoPayment::find()->where(['tool_po_id' => $id])->andWhere(['<>', 'status', 0])->all();
        }


        return $this->render('preview', [
            'model' => $this->findModel($id),
            'currAttachment' => $currAttachment,
            'payment' => $payment,
            'oldPayment' => $oldPayment,
            'detail' => ToolPoDetail::find()->where(['tool_po_id' => $id ])->all(),
        ]);
    }
    /**
     * Deletes an existing ToolPo model by changing the delete status to 1 .
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
            'detail' => ToolPoDetail::find()->where(['tool_po_id' => $id ])->all(),
        ]);
    }


    /**
     * Deletes an existing Quotation by changing the delete status to 1
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteColumn($id)
    {
        $model = $this->findModel($id);
        $model->deleted = 1;
        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'Tool Order deleted');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to delete Tool Order');
        }

        return $this->redirect(['index']);
    }




    public function actionAjaxAddress()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $supplierId = Yii::$app->request->post()['supplierId'];
            print_r($supplierId);
            $supplier = Supplier::find()->where(['id' => $supplierId])->one();
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
            $supplier = Supplier::find()->where(['id' => $supplierId])->one();
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
        $detail = new ToolPoDetail();
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


    public function actionRemoveAttachment($id)
    {
        $woa = TpoAttachment::find()->where( ['id' => $id] )->one();
        $att = $woa->value;

            /* remove file */
            $fileName = "uploads/TpoAttachment/$att";
            unlink($fileName);

        if ( $woa->delete() ) {
            Yii::$app->getSession()->setFlash('success', 'Attachment removed!');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to remove the attachment!');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
    *Protected Functions
    */

    protected function composeEmail($model){
      $data = Setting::find()->where(['id'=>42])->one();
      $dataEx = explode(',', $data->value);
      $poNumber = ToolPO::getTPONo($model->purchase_order_no,$model->created);
      $link = Html::a('Link', Url::to(['tool-po/preview','id'=>$model->id], true));
      $message = '';
      $message .= "<p>TPO {$poNumber} has been created</p>";
      $message .= "<p>Please click on the link below to review the Purchase Order</p>";
      $message .= $link;
      $message .= "<p><i>This is a system generated email, please do not reply.</i></p>";

      $data = Yii::$app->mailer->compose()
      ->setTo($dataEx)
      ->setFrom(['info@aeroindustriesasia.com' => 'info@aeroindustriesasia.com'])
      ->setSubject('Tool PO Created')
      ->setHtmlBody($message)
      ->send();



    }


}
