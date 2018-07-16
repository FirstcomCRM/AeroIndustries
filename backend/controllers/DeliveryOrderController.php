<?php

namespace backend\controllers;

use Yii;
use common\models\DeliveryOrder;
use common\models\SearchDeliveryOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Address;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\WorkOrder;
use common\models\Customer;
use common\models\WorkOrderPart;
use common\models\DeliveryOrderDetail;

/**
 * DeliveryOrderController implements the CRUD actions for DeliveryOrder model.
 */
class DeliveryOrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'DeliveryOrder'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all DeliveryOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchDeliveryOrder();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
/**
 * crud
 */

        /**
         * Finds the DeliveryOrder model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return DeliveryOrder the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = DeliveryOrder::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }


/**
 * custom
 */
    /**
     * Creates a new DeliveryOrder .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew($id=null)
    {
        $model = new DeliveryOrder();
        $detail = new DeliveryOrderDetail();
        $workOrder = false;

        $wOcustomerId = '';
        $wOPartNo = '';
        $wOQty = '';
        $wOId = '';
        $wORemark = '';

        $customerAddresses = array();
        if ( $id !== null ) {
            $workOrder = WorkOrder::find()->where(['id' => $id])->one();
            $workOrderPart = WorkOrderPart::getWorkOrderPart($id);
            $wOcustomerId = $workOrder->customer_id;

            $model->customer_id = $wOcustomerId;
            $customerBillAddress = Address::find()->where(['customer_id' => $wOcustomerId])->andWhere(['address_type' => 'shipping'])->one();
            $model->ship_to = $customerBillAddress->id;
            $model->contact_no = $model->customer->contact_no;
            // $firstCustomer = Customer::find()->where(['id' => $wOcustomerId])->one();
            $addressesss = Address::find()->where(['customer_id' => $wOcustomerId])->andWhere(['address_type' => 'shipping'])->all();
            if ( $addressesss ) {
                foreach ($addressesss as $address){
                    $customerAddresses[$address->id] = $address->address;
                }
            }
        }
        if ($model->load(Yii::$app->request->post()) ) {
            // dx(Yii::$app->request->post());
            /* continue the previous po number */
            // $model->delivery_order_no = 1;
            // $ddo = DeliveryOrder::find()->where(['<>','status', 'cancelled'])->orderBy('delivery_order_no DESC')->limit(1)->one();
            // if ( !empty ( $ddo ) ) {
            //     $previousNo = $ddo->delivery_order_no;
            //     $model->delivery_order_no = $previousNo+1;
            // }

            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;
            $model->attachment = UploadedFile::getInstances($model, 'attachment');
            foreach ($model->attachment as $file) {
                $fileName = md5(date("YmdHis")).'-'.$file->name;
                $file->saveAs('uploads/do/'.$fileName);
                $model->value = $fileName;
                $model->is_attachment = 0;
                if ( !empty( $fileName ) ) {
                    $model->is_attachment = 1;
                }
                $model->attachment = true;
            }
            if ($model->save()) {
                $workOrder->is_do = 1;
                $workOrder->delivery_order_id = $model->id;
                $workOrder->save();
                
                $deliveryOrderId = $model->id;

                if ($detail->load(Yii::$app->request->post()) ) {
                    $partNoArray = $detail->part_no;

                    foreach ( $partNoArray as $key => $partNo ) {

                        if ( !empty ( $partNo ) ) {
                            $newDetail = new DeliveryOrderDetail();
                            $newDetail->delivery_order_id = $deliveryOrderId;
                            $newDetail->part_no = $partNo;
                            $newDetail->desc = $detail->desc[$key];
                            $newDetail->quantity = $detail->quantity[$key];
                            $newDetail->work_order_no = $detail->work_order_no[$key];
                            $newDetail->remark = $detail->remark[$key];
                            $newDetail->po_no = $detail->po_no[$key];
                            $newDetail->save();
                        }

                    }
                }

                return $this->redirect(['index']);
            }
        } 
        return $this->render('new', [
            'model' => $model,
            'workOrder' => $workOrder,
            'workOrderPart' => $workOrderPart,
            'detail' => $detail,
            'customerAddresses' => $customerAddresses,
        ]);
        
    }


    /**
     * Displays a single DeliveryOrder .
     * @param integer $id
     * @return mixed
     */
    public function actionPreview($id)
    {   
        $detail = DeliveryOrderDetail::find()->where(['delivery_order_id' => $id])->all();
        return $this->render('preview', [
            'model' => $this->findModel($id),
            'detail' => $detail,
        ]);
    }


    /**
     * Deletes an existing DeliveryOrder model by changing the delete status to 1 .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRemove($id)
    {
        $model = $this->findModel($id);
        
        $workOrder = WorkOrder::find()->where(['delivery_order_id' => $id])->one();
        $workOrder->delivery_order_id = NULL;
        $workOrder->is_do = 0;
        $workOrder->save();

        $model->status = 'voided';
        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'DO Voided');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to void DO');
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing DeliveryOrder model by changing the delete status to 1 .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        $workOrder = WorkOrder::find()->where(['delivery_order_id' => $id])->one();
        if (WorkOrder::find()->where(['delivery_order_id' => $id])->exists()){
            $workOrder->delivery_order_id = NULL;
            $workOrder->is_do = 0;
            $workOrder->save();
        }
        $model->deleted = 1;

        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'DO Deleted');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to delete DO');
        }

        return $this->redirect(['index']);
    }
    /**
     * Print a single DeliveryOrder .
     * @param integer $id
     * @return mixed
     */
    public function actionPrint($id)
    {   
        $this->layout = 'print';
        $detail = DeliveryOrderDetail::find()->where(['delivery_order_id' => $id])->all();
        return $this->render('print', [
            'model' => $this->findModel($id),
            'detail' => $detail,
        ]);
    }

/**
 * AJAX
 */

    /* to enable ajax function */
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * AJAX FUNCTION.
     */
    public function actionAjaxPart()
    {   
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $noLoop = Yii::$app->request->post()['noLoop'];
            $noLoop ++;
            return $this->render('ajax-part', [
                'noLoop' => $noLoop,
            ]);
        }
    }
    /**
     * Get addresses based on customer id selected.
     * 
     */
    
    public function actionAjaxAddress()
    {   
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $customerId = Yii::$app->request->post()['customerId'];
            $address = Address::find()->where(['customer_id' => $customerId,'address_type'=>'shipping'])->all();
            return $this->render('ajax-address', [
                'address' => $address,
            ]);
        }
    }
}
