<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use common\models\PurchaseOrder;
use common\models\PurchaseOrderDetail;
use common\models\PurchaseOrderPayment;
use common\models\SearchPurchaseOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\base\ErrorException;
use yii\helpers\BaseUrl;
use yii\helpers\Url;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\Part;
use common\models\Supplier;
use common\models\Currency;
use common\models\Unit;
use common\models\PurchaseOrderAttachment;
use common\models\Setting;

use imanilchaudhari\CurrencyConverter\CurrencyConverter;

/**
 * PurchaseOrderController implements the CRUD actions for PurchaseOrder model.
 */
class PurchaseOrderController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');

        foreach ( $userGroupArray as $uGId => $uGName ){
            $permission = UserPermission::find()->where(['controller' => 'PurchaseOrder'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all PurchaseOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchPurchaseOrder();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Finds the PurchaseOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



   /**
     * add new PO.
     * If creation is successful, the browser will be redirected to the 'preview' page.
     * @return mixed
     */
    public function actionNew()
    {
        $model = new PurchaseOrder();
        $detail = new PurchaseOrderDetail();
        $poAttachment = new PurchaseOrderAttachment();
        $firstSupplier = Supplier::find()->one();
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
            /* continue the previous po number */
            $model->purchase_order_no = 1;
            $ppo = PurchaseOrder::find()->where(['<>','deleted', 1])->orderBy('purchase_order_no DESC')->limit(1)->one();
            if ( !empty ( $ppo ) ) {
                $previousNo = $ppo->purchase_order_no;
                $model->purchase_order_no = $previousNo+1;
            }
            if ( $model->save() ) {
                $purchaseOrderId = $model->id;
                if ( $detail->load(Yii::$app->request->post()) ) {
                    foreach ( Yii::$app->request->post()['PurchaseOrderDetail'] as $d ) {
                        $poD = new PurchaseOrderDetail();
                        $poD->purchase_order_id = $purchaseOrderId;
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
                        $file->saveAs('uploads/PurchaseOrderAttachment/'.$fileName);
                        /* image upload */
                        $poA = new PurchaseOrderAttachment();
                        $poA->purchase_order_id = $purchaseOrderId;
                        $poA->value = $fileName;
                        $poA->save();
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
            'poAttachment' => $poAttachment,
            'supplierAddresses' => $supplierAddresses,
        ]);
    }
    /**
     * edit PO.
     * If creation is successful, the browser will be redirected to the 'preview' page.
     * @return mixed
     */
    public function actionEdit($id)
    {
        $model = PurchaseOrder::getPurchaseOrder($id);
        $detail = new PurchaseOrderDetail();
        $oldDetail = PurchaseOrderDetail::getPurchaseOrderDetail($id);
        $supplierId = $model->supplier_id;
        $poAttachment = new PurchaseOrderAttachment();
        $currAttachment = PurchaseOrderAttachment::getPurchaseOrderAttachment($id);
        $firstSupplier = Supplier::getSupplier($supplierId);
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
                    PurchaseOrderDetail::deleteAll(['purchase_order_id' => $purchaseOrderId]);
                    foreach ( Yii::$app->request->post()['PurchaseOrderDetail'] as $d ) {
                        $poD = new PurchaseOrderDetail();
                        $poD->purchase_order_id = $purchaseOrderId;
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
            'currAttachment' => $currAttachment,
            'poAttachment' => $poAttachment,
        ]);
    }
    /**
     * preview PO .
     * @param integer $id
     * @return mixed
     */
    public function actionPreview($id)
    {
        $payment = new PurchaseOrderPayment();
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
        if ( PurchaseOrderPayment::find()->where(['purchase_order_id' => $id])->exists() ) {
            $oldPayment = PurchaseOrderPayment::find()->where(['purchase_order_id' => $id])->andWhere(['<>', 'status', 0])->all();
        }


        return $this->render('preview', [
            'model' => $this->findModel($id),
            'payment' => $payment,
            'oldPayment' => $oldPayment,
            'detail' => PurchaseOrderDetail::find()->where(['purchase_order_id' => $id ])->all(),
        ]);
    }

    public function actionRemovePayment($id){

        $payment = PurchaseOrderPayment::find()->where(['id' => $id])->one();
        $poId = $payment->purchase_order_id;
        $po = PurchaseOrder::find()->where(['id' => $poId])->one();

        $payment->status = 0 ;
        $payment->save();


            $sumAmt = PurchaseOrderPayment::find()->where(['purchase_order_id' => $poId])->andWhere(['<>','status','0'])->sum('amount');
            $totalAmt = $po->grand_total;



        if ( $totalAmt > $sumAmt && $sumAmt > 0 ) {
            $po->status = 2; /* partially paid */
        } else if ( $sumAmt <= 0 ) {
            $po->status = 0; /* unpaid */
        } else if ( $sumAmt >= $totalAmt ) {
            $po->status = 1; /* fully paid */
        }

        $po->save();


        return $this->redirect(['preview', 'id' => $poId]);

    }


    /* to enable ajax function */
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
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
            Yii::$app->getSession()->setFlash('success', 'Purchase Order deleted');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to delete Purchase Order');
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
            'detail' => PurchaseOrderDetail::find()->where(['purchase_order_id' => $id ])->all(),
        ]);
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
        $detail = new PurchaseOrderDetail();
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
     * Get addresses based on supplier id selected.
     *
     */

    public function actionAjaxAddress()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $supplierId = Yii::$app->request->post()['supplierId'];
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
     * Get attention based on supplier id selected.
     *
     */

    public function actionAjaxCurrency()
    {
        $converter = new CurrencyConverter();
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $currencyId = Yii::$app->request->post()['selectedCurrId'];
            $currency = Currency::find()->where(['id' => $currencyId])->one();

            $data['iso'] = $currency->iso;

            $rate = 0;
            try{
                $rate = $converter->convert($currency->iso, 'USD');
            }catch (ErrorException $e) {
                $ex = Yii::$app->errorHandler->exception;
                $rate = Currency::dataCurrencyRate()[$currencyId];
            }
            $data['rate'] = $rate;

            return json_encode($data);

        }
    }

    protected function composeEmail($model){
      $data = Setting::find()->where(['name'=>'PO Email Notification'])->one();
      $poNumber = PurchaseOrder::getPONo($model->purchase_order_no,$model->created);
    //  $link = Html::a('Link',['purchase-order/preview','id'=>$model->id]);
    //  $link = 'http://www.aeroindustries3011.firstcomdemolinks.com/system88/backend/web/index.php?r=purchase-order%2Fpreview&id='.$model->id;
      $link = Html::a('link text', Url::to(['purchase-order/preview','id'=>$model->id], true));
      $message = '';
      $message .= "<p>PO {$poNumber} has been created</p>";
      $message .= $link;

      //print_r($message);die();
    //  $data = Setting::find()->where(['name'=>'PO Email Notification'])->one();
    //  $message = 'Test email to see if email is working';

      $data = Yii::$app->mailer->compose()
      ->setTo($data->value)
    //    ->setTo('eumerjoseph.ramos@yahoo.com')
      ->setFrom(['info@aeriindustriesdemo.com' => 'info@aeriindustriesdemo.com'])
      ->setSubject('PO Created')
      ->setHtmlBody($message)
    //  ->setReplyTo([$eng->email])
    //  ->attachContent($attach,['fileName'=>$model->service_no.'.pdf','contentType' => 'application/pdf'])
      //  ->setFrom([$eng->email => $eng->fullname])
      //      ->setCc($testcc) //temp
      ->send();



    }

}
