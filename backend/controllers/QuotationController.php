<?php

namespace backend\controllers;

use Yii;
use common\models\Quotation;
use common\models\QuotationDetail;
use common\models\QuotationAttachment;
use common\models\SearchQuotation;
use common\models\Part;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\Customer;
use common\models\WorkOrder;
use common\models\Address;
use common\models\Setting;
use common\models\Uphostery;

/**
 * QuotationController implements the CRUD actions for Quotation model.
 */
class QuotationController extends Controller
{
    /**
     * @inheritdoc
     */
    
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Quotation'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all Quotation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchQuotation();
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
     * Finds the Quotation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quotation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quotation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

/**
 * custom
*/

    /**
     * Creates a new Quotation .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew()
    {
        $model = new Quotation();
        $detail = new QuotationDetail();
        $qAttachment = new QuotationAttachment();
        $firstCustomer = Customer::find()->one();
        $customerAddresses = array();
        if ( $firstCustomer ) {
            $address = Address::find()->where(['customer_id' => $firstCustomer->id,'address_type'=>'billing'])->all();
            $customerAddresses[$firstCustomer->addr_1] = $firstCustomer->addr_1;
            $customerAddresses[$firstCustomer->addr_2] = $firstCustomer->addr_2;
        }

        if ($model->load(Yii::$app->request->post()) ) {
            /* if no item was selected, redirect back*/
            if ( ! $detail->load(Yii::$app->request->post()) ) {
                Yii::$app->getSession()->setFlash('error', 'Please select parts or services!');
                return $this->redirect(['new']);
            }
            /* save user involved */
            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;

            /* continue the previous quo number */
            $model->quotation_no = 1;
            $quoP = Quotation::find()->where(['<>','deleted', 1])->orderBy('quotation_no DESC')->limit(1)->one();
            if ( !empty ( $quoP ) ) {
                $previousNo = $quoP->quotation_no;
                $model->quotation_no = $previousNo+1;
            }



            if ( $model->save() ) {
                $quotationId = $model->id;

                if ( $detail->load(Yii::$app->request->post()) ) {

                    foreach ( Yii::$app->request->post()['QuotationDetail'] as $d ) { 

                        $quo = new QuotationDetail();
                        $quo->quotation_id = $quotationId;


                        $quo->service_details = $d['service_details'];
                        $quo->group = $d['group'];
                        $quo->work_type = $d['work_type'];
                        $quo->quantity = $d['quantity'];
                        $quo->unit_price = $d['unit_price'];
                        $quo->subtotal = $d['subTotal'];

                        $quo->save();

                    }


                } /* if load detail */ 


                if ( $qAttachment->load(Yii::$app->request->post()) ) {
                    $qAttachment->attachment = UploadedFile::getInstances($qAttachment, 'attachment');

                    foreach ($qAttachment->attachment as $file) {

                        $fileName = md5(date("YmdHis")).'-'.$file->name;
                        $qAttachmentClass = explode('\\', get_class($qAttachment))[2];
                        $file->saveAs('uploads/'.$qAttachmentClass.'/'.$fileName);
                        /* image upload */
                        $quoA = new QuotationAttachment();
                        $quoA->quotation_id = $quotationId;
                        $quoA->value = $fileName;
                        $quoA->save();

                    }
                        
                }/* if load attachment */ 
                
                return $this->redirect(['preview', 'id' => $model->id]);
            } /* if save model */

                
        } 
        return $this->render('new', [
            'model' => $model,
            'detail' => $detail,
            'qAttachment' => $qAttachment,
            'customerAddresses' => $customerAddresses,
        ]);
        
    }


    /**
     * Displays a single Quotation .
     * @param integer $id
     * @return mixed
     */
    public function actionPreview($id)
    {           
        $attachment = QuotationAttachment::find()->where(['quotation_id' => $id])->all();


        $newAttachment = new QuotationAttachment();

        if ( $newAttachment->load(Yii::$app->request->post()) ) {
            $newAttachment->attachment = UploadedFile::getInstances($newAttachment, 'attachment');

            foreach ($newAttachment->attachment as $file) {

                $fileName = md5(date("YmdHis")).'-'.$file->name;
                $qAttachmentClass = explode('\\', get_class($newAttachment))[2];
                $file->saveAs('uploads/'.$qAttachmentClass.'/'.$fileName);
                /* image upload */
                $quoA = new QuotationAttachment();
                $quoA->quotation_id = $id;
                $quoA->value = $fileName;
                $quoA->save();

            }
            return $this->redirect(['preview', 'id' => $id]);
                
        }/* if load attachment */ 

        return $this->render('preview', [
            'newAttachment' => $newAttachment,
            'model' => $this->findModel($id),
            'attachment' => $attachment,
            'detail' => QuotationDetail::find()->where(['quotation_id' => $id ])->all(),
        ]);
    }

    /**
     * print Quotation in the preview page
     * @param integer $id
     * @return mixed
     */
    public function actionPrint($id)
    {
        $this->layout = 'print';

        $attachment = QuotationAttachment::find()->where(['quotation_id' => $id])->all();


        return $this->render('print', [
            'model' => $this->findModel($id),
            'attachment' => $attachment,
            'detail' => QuotationDetail::find()->where(['quotation_id' => $id ])->all(),
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
            Yii::$app->getSession()->setFlash('success', 'Quotation deleted');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to delete Quotation');
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
            Yii::$app->getSession()->setFlash('success', 'Quotation Approved');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to approve the Quotation');
        }

        return $this->redirect(['index']);
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
            Yii::$app->getSession()->setFlash('success', 'Quotation Cancelled');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to cancel the Quotation');
        }

        return $this->redirect(['index']);
    }

    /* to enable ajax function */
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

/**
 * 
 *
 *  AJAX FUNCTION.
 *
 */

    /**
     * Temporary save the item selection.
     * 
     */
    
    public function actionAjaxPart()
    {   
        $detail = new QuotationDetail();
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            // d(Yii::$app->request->post());exit;
           
            $serviceDetail = Yii::$app->request->post()['serviceDetail'];

            $n = Yii::$app->request->post()['n'];
            $qty = Yii::$app->request->post()['qty'];
            $unit = Yii::$app->request->post()['unit'];
            $group = Yii::$app->request->post()['group'];
            $subTotal = Yii::$app->request->post()['subTotal'];
            $workType = Yii::$app->request->post()['workType'];
            

            return $this->render('ajax-part', [
                'n' => $n,
                'qty' => $qty,
                'serviceDetail' => $serviceDetail,
                'unit' => $unit,
                'subTotal' => $subTotal,
                'group' => $group,
                'detail' => $detail,
                'workType' => $workType,
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
            $address = Address::find()->where(['customer_id' => $customerId,'address_type'=>'billing'])->all();
            return $this->render('ajax-address', [
                'address' => $address,
            ]);
        }
    }
    public function actionAjaxWorkorder()
    {   
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $dataWorkOrder = WorkOrder::dataWorkOrder();
            $dataWorkO = [];
            foreach ( $dataWorkOrder as $id => $dwo ) {
                $workOrder = WorkOrder::getWorkOrder($id);
                if ( $workOrder->work_scope && $workOrder->work_type ) {
                    $woNumber = Setting::getWorkNo($workOrder->work_type,$workOrder->work_scope,$workOrder->work_order_no);
                    $dataWorkO[$id] = $woNumber;
                }
            }
            return $this->render('ajax-workorder', [
                'dataWorkO' => $dataWorkO,
            ]);
        }
    }
    public function actionAjaxUphostery()
    {   
        $this->layout = false;
        $dataUphostery = Uphostery::dataUphostery();
        $dataUphoster = [];
        foreach ( $dataUphostery as $id => $dU ) {
            $uphostery = Uphostery::getUphostery($id);
            if ( $uphostery->uphostery_scope && $uphostery->uphostery_type ) {
                $upNumber = Setting::getUphosteryNo($uphostery->uphostery_type,$uphostery->uphostery_scope,$uphostery->uphostery_no);
                $dataUphoster[$id] = $upNumber;
            }
        }
        return $this->render('ajax-uphostery', [
            'dataUphoster' => $dataUphoster,
        ]);
    }
    /**
     * Get addresses based on customer id selected.
     * 
     */
    
    public function actionAjaxCustomer()
    {   
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $woId = Yii::$app->request->post()['woId'];
            $quotation_type = Yii::$app->request->post()['quotation_type'];
            if ($quotation_type == 'work_order'){
                $workOrder = WorkOrder::find()->where(['id' => $woId])->one();
                return $workOrder->customer_id;
            } else {
                $uphostery = Uphostery::find()->where(['id' => $woId])->one();
                return $uphostery->customer_id;
            }
        }
    }


}
