<?php

namespace backend\controllers;

use Yii;
use common\models\DeliveryOrder;
use common\models\SearchDeliveryOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
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
            $model->ship_to = $model->customer->s_addr_1;
            $model->contact_no = $model->customer->contact_no;
            $firstCustomer = Customer::find()->where(['id' => $wOcustomerId])->one();
            if ( $firstCustomer ) {
                $customerAddresses[$firstCustomer->addr_1] = $firstCustomer->addr_1;
                $customerAddresses[$firstCustomer->addr_2] = $firstCustomer->addr_2;
            }
        }
        if ($model->load(Yii::$app->request->post()) ) {
            // d(Yii::$app->request->post());exit;
            /* continue the previous po number */
            $model->delivery_order_no = 1;
            $ddo = DeliveryOrder::find()->where(['<>','status', 'cancelled'])->orderBy('delivery_order_no DESC')->limit(1)->one();
            if ( !empty ( $ddo ) ) {
                $previousNo = $ddo->delivery_order_no;
                $model->delivery_order_no = $previousNo+1;
            }

            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;
            if ($model->save()) {
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
                            $newDetail->save();
                        }

                    }
                }

                return $this->redirect(['preview', 'id' => $model->id]);
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
        $model->status = 0;
        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'Customer deleted');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to delete Customer');
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
        $detail = new QuotationDetail();
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
