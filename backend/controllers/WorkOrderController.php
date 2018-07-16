<?php

namespace backend\controllers;

use Yii;
use common\models\WorkOrder;
use common\models\SearchWorkOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\WorkOrderPart;
use common\models\Template;
use common\models\WorkOrderArc;
use common\models\WorkHiddenDamage;
use common\models\WoFinalAttachment;
use common\models\WoPreAttachment;
use common\models\WoDispositionAttachment;
use common\models\WorkOrderAttachment;
use common\models\WorkOrderStaff;
use common\models\WorkStockRequisition;
use common\models\WorkPreliminary;
use common\models\Staff;
use common\models\Traveler;
use common\models\Tool;
use common\models\Part;
use common\models\Stock;
use common\models\Unit;
use common\models\FinalInspection;
use common\models\Capability;
use common\models\Quarantine;
use common\models\Customer;
use yii\web\UploadedFile;
/**
 * WorkOrderController implements the CRUD actions for WorkOrder model.
 */
class WorkOrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');

        foreach ( $userGroupArray as $uGId => $uGName ){
            $permission = UserPermission::find()->where(['controller' => 'WorkOrder'])->andWhere(['user_group_id' => $uGId ] )->all();
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
/* crud */
    /**
     * Lists all WorkOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchWorkOrder();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Deletes an existing WorkOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WorkOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WorkOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



/* custom  */
    /**
     * Creates a new WorkOrder .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew()
    {
        $model = new WorkOrder();
        $woAttachment = new WorkOrderAttachment();
        $workOrderPart = new WorkOrderPart();
        $staff = new WorkOrderStaff();

        $data['model'] = $model;
        $data['woAttachment'] = $woAttachment;
        $data['workOrderPart'] = $workOrderPart;
        $data['gotTemplate'] = false;
        $data['staff'] = $staff;
        $session = Yii::$app->session;
        if ( $model->load( Yii::$app->request->post() ) ) {
            // dx(Yii::$app->request->post());
                $workOrderPart->load(Yii::$app->request->post());
                $workOrderId = WorkOrder::saveWo($model);
                $this->saveWoAttachment($woAttachment, $workOrderId,0);
                $this->saveStaff($staff,$workOrderId);
                WorkOrderPart::saveWo($workOrderPart,$workOrderId);
                Yii::$app->getSession()->setFlash('success', 'Work Order Created!');
                return $this->redirect(['preview', 'id' => $model->id]);
        }
        return $this->render('new', [
            'data' => $data
        ]);
    }

    /**f
     * Edit an existing WorkOrder .
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $data = array();
        $model = $this->findModel($id);
        $workOrderPart = new WorkOrderPart();
        $eworkOrderPart = WorkOrderPart::getWorkOrderPart($id);
        $workOrderId = $id;
        $woAttachment = new WorkOrderAttachment();
        $currWoAtt = WorkOrderAttachment::getWorkOrderAttachmentW($workOrderId);

        $staff = new WorkOrderStaff();
        $finalInspector = WorkOrderStaff::getFinalInspector($workOrderId);
        $inspector = WorkOrderStaff::getInspector($workOrderId);
        $supervisor = WorkOrderStaff::getSupervisor($workOrderId);
        $technician = WorkOrderStaff::getTechnician($workOrderId);
        $WorkStockRequisition = WorkStockRequisition::getWSRByWorkOrderId($id);
        /* templte */
        $gotTemplate = false;
        $data['model'] = $model;
        $data['woAttachment'] = $woAttachment;
        $data['staff'] = $staff;
        $data['inspector'] = $inspector;
        $data['finalInspector'] = $finalInspector;
        $data['supervisor'] = $supervisor;
        $data['technician'] = $technician;
        $data['workOrderPart'] = $workOrderPart;
        $data['currWoAtt'] = $currWoAtt;
        $data['eworkOrderPart'] = $eworkOrderPart;
        $data['gotTemplate'] = $gotTemplate;
        $data['WorkStockRequisition'] = $WorkStockRequisition;

        if ( $model->load( Yii::$app->request->post() ) ) {
            // dx(Yii::$app->request->post());exit;
            $model->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->updated = $currentDateTime;
            if ( $model->save() ) {
                $this->saveWoAttachment($woAttachment, $id,0);
                $workOrderPart->load(Yii::$app->request->post());
                WorkOrderPart::saveWo($workOrderPart,$id);
                $this->saveStaff($staff,$id);
                Yii::$app->getSession()->setFlash('success', 'Work Order Updated!');
                return $this->redirect(['preview', 'id' => $model->id]);
            }
            /* after save, proceed to next part */
            /* allow them to assign parts for fix later */
            Yii::$app->getSession()->setFlash('success', 'Work Order Created! Please fill up the bill of material');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'data' => $data,
        ]);
    }
    public function actionProcessingInspection($id,$work_order_part_id){

        $model = $this->findModel($id);
        $woAttachment = new WorkOrderAttachment();
        $workOrderPart = new WorkOrderPart();
        $eworkOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $currPoAtt = WorkOrderAttachment::getWorkOrderAttachmentPI($id,$work_order_part_id);

        $data['model'] = $model;
        $data['eworkOrderPart'] = $eworkOrderPart;
        $data['workOrderPart'] = $workOrderPart;
        $data['woAttachment'] = $woAttachment;
        $data['currPoAtt'] = $currPoAtt;

        if ( $woAttachment->load(Yii::$app->request->post()) ) {
            // dx(Yii::$app->request->post());
            $this->saveWoAttachment($woAttachment, $id,$work_order_part_id);

            Yii::$app->getSession()->setFlash('success', 'Processing Inspection Updated!');
            return $this->redirect(['preview', 'id' => $model->id]);
        }

        return $this->render('processing-inspection', [
            'data' => $data,
        ]);
    }
    public function actionReceivingInspection($id,$work_order_part_id){

        $model = $this->findModel($id);
        $woAttachment = new WorkOrderAttachment();
        $workOrderPart = new WorkOrderPart();
        $eworkOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $currWoAtt = WorkOrderAttachment::getWorkOrderAttachmentR($id,$work_order_part_id);

        $data['model'] = $model;
        $data['eworkOrderPart'] = $eworkOrderPart;
        $data['workOrderPart'] = $workOrderPart;
        $data['woAttachment'] = $woAttachment;
        $data['currWoAtt'] = $currWoAtt;

        if ( $eworkOrderPart->load(Yii::$app->request->post()) ) {
            // dx(Yii::$app->request->post());
            $eworkOrderPart->created_by = Yii::$app->user->identity->id;
            $this->saveWoAttachment($woAttachment, $id,$work_order_part_id);
            $currentDateTime = date("Y-m-d H:i:s");
            $eworkOrderPart->created = $currentDateTime;
            $eworkOrderPart->save();

            Yii::$app->getSession()->setFlash('success', 'Receiving Inspection Updated!');
            return $this->redirect(['preview', 'id' => $model->id]);
        }

        return $this->render('receiving-inspection', [
            'data' => $data,
        ]);
    }
    public function actionPreliminaryInspection($id,$work_order_part_id){

        $model = $this->findModel($id);
        $woAttachment = new WorkOrderAttachment();
        $workOrderPart = new WorkOrderPart();
        $eworkOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $currPreAtt = WorkOrderAttachment::getWorkOrderAttachmentP($id,$work_order_part_id);
        $currDisAtt = WorkOrderAttachment::getWorkOrderAttachmentD($id,$work_order_part_id);
        $workPreliminary = WorkPreliminary::getWorkPreliminary($id,$work_order_part_id);
        if ( ! $workPreliminary ) {
            $workPreliminary = new WorkPreliminary();
        }

        $data['model'] = $model;
        $data['eworkOrderPart'] = $eworkOrderPart;
        $data['workOrderPart'] = $workOrderPart;
        $data['woAttachment'] = $woAttachment;
        $data['currPreAtt'] = $currPreAtt;
        $data['currDisAtt'] = $currDisAtt;

        $data['workPreliminary'] = $workPreliminary;

        if ( $eworkOrderPart->load(Yii::$app->request->post()) ) {
            $eworkOrderPart->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $eworkOrderPart->updated = $currentDateTime;
            $eworkOrderPart->save();
            $this->savePreliminary($workPreliminary,$id, $work_order_part_id);
            $this->saveWoAttachment($woAttachment, $id,$work_order_part_id);

            Yii::$app->getSession()->setFlash('success', 'Preliminary Inspection Updated!');
            return $this->redirect(['preview', 'id' => $model->id]);
        }

        return $this->render('preliminary-inspection', [
            'data' => $data,
        ]);
    }
    public function actionHiddenDamage($id,$work_order_part_id){

        $model = $this->findModel($id);
        $woAttachment = new WorkOrderAttachment();
        $workOrderPart = new WorkOrderPart();
        $eworkOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $currHidAtt = WorkOrderAttachment::getWorkOrderAttachmentH($id,$work_order_part_id);
        $hiddenDamage = WorkHiddenDamage::getWorkHiddenDamage($id,$work_order_part_id);
        if ( ! $hiddenDamage ) {
            $hiddenDamage = new WorkHiddenDamage();
        }
        $data['model'] = $model;
        $data['eworkOrderPart'] = $eworkOrderPart;
        $data['workOrderPart'] = $workOrderPart;
        $data['woAttachment'] = $woAttachment;
        $data['currHidAtt'] = $currHidAtt;
        $data['hiddenDamage'] = $hiddenDamage;

        if ( $eworkOrderPart->load(Yii::$app->request->post()) ) {
            $eworkOrderPart->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $eworkOrderPart->updated = $currentDateTime;
            $eworkOrderPart->save();
            $this->saveHiddenDamage($hiddenDamage,$id, $work_order_part_id);
            $this->saveWoAttachment($woAttachment, $id,$work_order_part_id);

            Yii::$app->getSession()->setFlash('success', 'Hidden Damage Inspection Updated!');
            return $this->redirect(['preview', 'id' => $model->id]);
        }

        return $this->render('hidden-damage', [
            'data' => $data,
        ]);
    }
    public function actionWorkSheet($id,$work_order_part_id){

        $model = $this->findModel($id);
        $woAttachment = new WorkOrderAttachment();
        $workOrderPart = new WorkOrderPart();
        $eworkOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $currWSAtt = WorkOrderAttachment::getWorkOrderAttachmentS($id,$work_order_part_id);

        $data['model'] = $model;
        $data['eworkOrderPart'] = $eworkOrderPart;
        $data['workOrderPart'] = $workOrderPart;
        $data['woAttachment'] = $woAttachment;
        $data['currWSAtt'] = $currWSAtt;

        if ( $eworkOrderPart->load(Yii::$app->request->post()) ) {
            $eworkOrderPart->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $eworkOrderPart->updated = $currentDateTime;
            $eworkOrderPart->save();
            $this->saveWoAttachment($woAttachment, $id,$work_order_part_id);

            Yii::$app->getSession()->setFlash('success', 'Work Sheet Updated!');
            return $this->redirect(['preview', 'id' => $model->id]);
        }

        return $this->render('work-sheet', [
            'data' => $data,
        ]);
    }

/* saving function */
        public function saveWoAttachment($woAttachment,$workOrderId,$workOrderPartId){
            if ( $woAttachment->load(Yii::$app->request->post()) ) {
                $woAttachment->attachment = UploadedFile::getInstances($woAttachment, 'attachment[work_order]');
                foreach ($woAttachment->attachment as $file) {
                    $fileName = md5(date("YmdHis")).'-'.$file->name;
                    $qAttachmentClass = explode('\\', get_class($woAttachment))[2];
                    $file->saveAs('uploads/work_order/'.$fileName);
                    /* image upload */
                    $woA = new WorkOrderAttachment();
                    $woA->work_order_id = $workOrderId;
                    $woA->work_order_part_id = 0;
                    $woA->type = 'work_order';
                    $woA->value = $fileName;
                    $woA->created_by = Yii::$app->user->identity->id;
                    $currentDateTime = date("Y-m-d H:i:s");
                    $woA->created = $currentDateTime;
                    $woA->save();
                }
                $woAttachment->attachment = UploadedFile::getInstances($woAttachment, 'attachment[receiving]');
                foreach ($woAttachment->attachment as $file) {
                    $fileName = md5(date("YmdHis")).'-'.$file->name;
                    $qAttachmentClass = explode('\\', get_class($woAttachment))[2];
                    $file->saveAs('uploads/receiving/'.$fileName);
                    /* image upload */
                    $woA = new WorkOrderAttachment();
                    $woA->work_order_id = $workOrderId;
                    $woA->work_order_part_id = $workOrderPartId;
                    $woA->type = 'receiving';
                    $woA->value = $fileName;
                    $woA->created_by = Yii::$app->user->identity->id;
                    $currentDateTime = date("Y-m-d H:i:s");
                    $woA->created = $currentDateTime;
                    $woA->save();
                }
                $woAttachment->attachment = UploadedFile::getInstances($woAttachment, 'attachment[processing_inspection]');
                foreach ($woAttachment->attachment as $file) {
                    $fileName = md5(date("YmdHis")).'-'.$file->name;
                    $qAttachmentClass = explode('\\', get_class($woAttachment))[2];
                    $file->saveAs('uploads/processing_inspection/'.$fileName);
                    /* image upload */
                    $woA = new WorkOrderAttachment();
                    $woA->work_order_id = $workOrderId;
                    $woA->work_order_part_id = $workOrderPartId;
                    $woA->type = 'processing_inspection';
                    $woA->value = $fileName;
                    $woA->created_by = Yii::$app->user->identity->id;
                    $currentDateTime = date("Y-m-d H:i:s");
                    $woA->created = $currentDateTime;
                    $woA->save();
                }
                $woAttachment->attachment = UploadedFile::getInstances($woAttachment, 'attachment[preliminary_inspection]');
                foreach ($woAttachment->attachment as $file) {
                    $fileName = md5(date("YmdHis")).'-'.$file->name;
                    $qAttachmentClass = explode('\\', get_class($woAttachment))[2];
                    $file->saveAs('uploads/preliminary_inspection/'.$fileName);
                    /* image upload */
                    $woA = new WorkOrderAttachment();
                    $woA->work_order_id = $workOrderId;
                    $woA->work_order_part_id = $workOrderPartId;
                    $woA->type = 'preliminary_inspection';
                    $woA->value = $fileName;
                    $woA->created_by = Yii::$app->user->identity->id;
                    $currentDateTime = date("Y-m-d H:i:s");
                    $woA->created = $currentDateTime;
                    $woA->save();
                }
                $woAttachment->attachment = UploadedFile::getInstances($woAttachment, 'attachment[disposition]');
                foreach ($woAttachment->attachment as $file) {
                    $fileName = md5(date("YmdHis")).'-'.$file->name;
                    $qAttachmentClass = explode('\\', get_class($woAttachment))[2];
                    $file->saveAs('uploads/disposition/'.$fileName);
                    /* image upload */
                    $woA = new WorkOrderAttachment();
                    $woA->work_order_id = $workOrderId;
                    $woA->work_order_part_id = $workOrderPartId;
                    $woA->type = 'disposition';
                    $woA->value = $fileName;
                    $woA->created_by = Yii::$app->user->identity->id;
                    $currentDateTime = date("Y-m-d H:i:s");
                    $woA->created = $currentDateTime;
                    $woA->save();
                }
                $woAttachment->attachment = UploadedFile::getInstances($woAttachment, 'attachment[final]');
                foreach ($woAttachment->attachment as $file) {
                    $fileName = md5(date("YmdHis")).'-'.$file->name;
                    $qAttachmentClass = explode('\\', get_class($woAttachment))[2];
                    $file->saveAs('uploads/final/'.$fileName);
                    /* image upload */
                    $woA = new WorkOrderAttachment();
                    $woA->work_order_id = $workOrderId;
                    $woA->work_order_part_id = $workOrderPartId;
                    $woA->type = 'final';
                    $woA->value = $fileName;
                    $woA->created_by = Yii::$app->user->identity->id;
                    $currentDateTime = date("Y-m-d H:i:s");
                    $woA->created = $currentDateTime;
                    $woA->save();
                }
                $woAttachment->attachment = UploadedFile::getInstances($woAttachment, 'attachment[traveler]');
                foreach ($woAttachment->attachment as $file) {
                    $fileName = md5(date("YmdHis")).'-'.$file->name;
                    $qAttachmentClass = explode('\\', get_class($woAttachment))[2];
                    $file->saveAs('uploads/traveler/'.$fileName);
                    /* image upload */
                    $woA = new WorkOrderAttachment();
                    $woA->work_order_id = $workOrderId;
                    $woA->work_order_part_id = $workOrderPartId;
                    $woA->type = 'traveler';
                    $woA->value = $fileName;
                    $woA->created_by = Yii::$app->user->identity->id;
                    $currentDateTime = date("Y-m-d H:i:s");
                    $woA->created = $currentDateTime;
                    $woA->save();
                }

            }
        }
        public function saveHiddenDamage($hiddenDamage,$workOrderId,$workOrderPartId){
            WorkHiddenDamage::deleteAll(['work_order_id' => $workOrderId, 'work_order_part_id' => $workOrderPartId, ]);
            if ( Yii::$app->request->post()['WorkHiddenDamage'] ) {
                $hiddenDamage = Yii::$app->request->post()['WorkHiddenDamage'];
                $hiddenDiscrepancy = $hiddenDamage['discrepancy'];
                $hiddenCorrective = $hiddenDamage['corrective'];
                foreach ( $hiddenDiscrepancy as $key => $preliD ) {
                    if ( !empty ( $preliD ) ) {
                        $newWP = new WorkHiddenDamage();
                        $newWP->work_order_id = $workOrderId;
                        $newWP->work_order_part_id = $workOrderPartId;
                        $newWP->discrepancy = $preliD;
                        $newWP->corrective = $hiddenCorrective[$key];
                        $newWP->created_by = Yii::$app->user->identity->id;
                        $currentDateTime = date("Y-m-d H:i:s");
                        $newWP->created = $currentDateTime;
                        $newWP->save();
                        $hiddenDamageId = $newWP->id;

                        $this->saveHiddenDamageAttachment($key,$hiddenDamageId,$workOrderId,$workOrderPartId);
                    }
                }
            }
        }
        /* the work order id will be representing hidden damage id in this case */
        public function saveHiddenDamageAttachment($key,$hiddenDamageId,$workOrderId,$workOrderPartId) {

            $woAttachment = new WorkOrderAttachment();
            if ( $woAttachment->load(Yii::$app->request->post()) ) {
                $woAttachment->attachment = UploadedFile::getInstances($woAttachment, "attachment[hidden_damage][$key]");
                foreach ($woAttachment->attachment as $file) {
                    $fileName = md5(date("YmdHis")).'-'.$file->name;
                    $qAttachmentClass = explode('\\', get_class($woAttachment))[2];
                    $file->saveAs('uploads/hidden_damage/'.$fileName);
                    /* image upload */
                    $woA = new WorkOrderAttachment();
                    $woA->work_order_id = $workOrderId;
                    $woA->work_order_part_id = $workOrderPartId;
                    $woA->type = 'hidden_damage';
                    $woA->value = $fileName;
                    $woA->created_by = Yii::$app->user->identity->id;
                    $currentDateTime = date("Y-m-d H:i:s");
                    $woA->created = $currentDateTime;
                    $woA->save();
                }
            }
        }
        public function saveStaff($staff,$workOrderId){
            WorkOrderStaff::deleteAll(['work_order_id' => $workOrderId]);
            if ( $staff->load( Yii::$app->request->post() ) ) {
                foreach ( $staff->staff_name as $key => $stf ) {
                    $staffName = $stf;
                    $staffType = $staff->staff_type[$key];
                    $woS = new WorkOrderStaff();
                    $woS->work_order_id = $workOrderId;
                    $woS->staff_type = $staffType;
                    $woS->staff_name = $staffName;
                    $woS->created_by = Yii::$app->user->identity->id;
                    $currentDateTime = date("Y-m-d H:i:s");
                    $woS->created = $currentDateTime;
                    $woS->save();
                }
            }
        }
        public function savePreliminary($workPreliminary,$workOrderId,$workOrderPartId){
            WorkPreliminary::deleteAll(['work_order_id' => $workOrderId, 'work_order_part_id' => $workOrderPartId, ]);
            if ( Yii::$app->request->post()['WorkPreliminary'] ) {
                $workPreliminary = Yii::$app->request->post()['WorkPreliminary'];
                $preliDiscrepancy = $workPreliminary['discrepancy'];
                $preliCorrective = $workPreliminary['corrective'];
                foreach ( $preliDiscrepancy as $key => $preliD ) {
                    if ( !empty ( $preliD ) ) {
                        $newWP = new WorkPreliminary();
                        $newWP->work_order_id = $workOrderId;
                        $newWP->work_order_part_id = $workOrderPartId;
                        $newWP->discrepancy = $preliD;
                        $newWP->corrective = $preliCorrective[$key];
                        $newWP->save();
                    }
                }
            }
        }
        public function saveWorkStockRequisition($workOrderId){
            d(Yii::$app->request->post());exit;
            if ( isset(Yii::$app->request->post()['used']) ){
                $useds = Yii::$app->request->post()['used'];
                foreach ( $useds as $wPUId => $used ) {
                    $WorkStockRequisition = WorkStockRequisition::getOneWorkStockRequisition($wPUId);
                    $WorkStockRequisition->qty_used = $used;
                    $WorkStockRequisition->save();
                }
            }
        }


    /**
     * Displays a single WorkOrder .
     * @param integer $id
     * @return mixed
     */
    public function actionPreview($id)
    {
        // $workPreliminary = WorkPreliminary::getWorkPreliminary($id);
        // $hiddenDamage = WorkHiddenDamage::getWorkHiddenDamage($id);
        // $currWoAtt = WorkOrderAttachment::getWorkOrderAttachmentW($id);
        // $currPreAtt = WorkOrderAttachment::getWorkOrderAttachmentP($id);
        // $currDisAtt = WorkOrderAttachment::getWorkOrderAttachmentD($id);
        // $currFinalAtt = WorkOrderAttachment::getWorkOrderAttachmentF($id);
        $WorkStockRequisition = WorkStockRequisition::getWSRByWorkOrderId($id);
        $workOrderParts = WorkOrderPart::getWorkOrderPart($id);
        foreach($workOrderParts as $workOrderPart):
            $workOrderArc[$workOrderPart->id] = WorkOrderArc::getWorkOrderArc($id,$workOrderPart->id);
        endforeach;
        $model = $this->findModel($id);
        $customer = Customer::getCustomer($model->customer_id);
        $supervisor = WorkOrderStaff::getSupervisor($id);
        $finalInspector = WorkOrderStaff::getFinalInspector($id);
        $technician = WorkOrderStaff::getTechnician($id);
        $inspector = WorkOrderStaff::getInspector($id);


        if ( Yii::$app->request->post() ){
            $postData = Yii::$app->request->post();
            $work_order_part_id = $postData['work_order_part_id'];
            $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
            $checklist = $postData['checklist'];
            $length = count($checklist);
            $workOrderPart->is_processing = 0;
            $workOrderPart->is_receiving = 0;
            $workOrderPart->is_preliminary = 0;
            $workOrderPart->is_hidden = 0;
            $workOrderPart->is_traveler = 0;
            $workOrderPart->is_final = 0;
            foreach ( $checklist as $key => $c ) {
                $workOrderPart[$key] = 1;
            }
            if ( $length == 6 ) {
                $workOrderPart->status = 'Completed';
            } else {
                $workOrderPart->status = 'Pending';
            }
            $workOrderPart->save();
            return $this->redirect(['preview','id' => $id]);
        }

        return $this->render('preview', [
            'model' => $model,
            'workOrderArc' => $workOrderArc,
            'supervisor' => $supervisor,
            'inspector' => $inspector,
            'finalInspector' => $finalInspector,
            'technician' => $technician,
            'customer' => $customer,
            // 'currPreAtt' => $currPreAtt,
            // 'currDisAtt' => $currDisAtt,
            // 'currWoAtt' => $currWoAtt,
            // 'hiddenDamage' => $hiddenDamage,
            // 'workPreliminary' => $workPreliminary,
            'WorkStockRequisition' => $WorkStockRequisition,
            'workOrderParts' => $workOrderParts,
        ]);
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
        $model->status = 'cancelled';
        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'Work Order Cancelled');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to cancel the Work Order');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
    /**
     * remove wo attachment
     * @param integer $id = work_order_attachment id
     * @return mixed
     */
    public function actionRemoveWoa($id)
    {
        $woa = WorkOrderAttachment::find()->where( ['id' => $id] )->one();
        $att = $woa->value;
        $type = $woa->type;

            /* remove file */
            $fileName = "uploads/$type/$att";
            unlink($fileName);

        if ( $woa->delete() ) {
            Yii::$app->getSession()->setFlash('success', 'Attachment removed!');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to remove the attachment!');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

/**
 * printing
*/
    /**
     * print a single WorkOrder .
     * @param integer $id
     * @return mixed
     */
    public function actionPrint($id,$work_order_part_id)
    {
        $this->layout = 'print';
        $model = $this->findModel($id);
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $supervisor = WorkOrderStaff::getSupervisor($id);
        $finalInspector = WorkOrderStaff::getFinalInspector($id);
        $technicians = WorkOrderStaff::getTechnician($id);
        $inspector = WorkOrderStaff::getInspector($id);

        $workPreliminary = WorkPreliminary::getWorkPreliminary($id,$work_order_part_id);
        $hiddenDamage = WorkHiddenDamage::getWorkHiddenDamage($id,$work_order_part_id);

        $att = WorkOrderAttachment::find()->where( ['work_order_id' => $id] )->andWhere( ['type' => 'hidden_damage'] )->all();


        return $this->render('print', [
            'model' => $model,
            'att' => $att,
            'supervisor' => $supervisor,
            'finalInspector' => $finalInspector,
            'inspector' => $inspector,
            'technicians' => $technicians,
            'workPreliminary' => $workPreliminary,
            'hiddenDamage' => $hiddenDamage,
            'workOrderPart' => $workOrderPart,
        ]);
    }
    /**
     * print a single WorkOrder .
     * @param integer $id
     * @return mixed
     */
    public function actionPrintReceiving($id,$work_order_part_id)
    {
        $this->layout = 'print';
        $model = $this->findModel($id);
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $supervisor = WorkOrderStaff::getSupervisor($id);
        $finalInspector = WorkOrderStaff::getFinalInspector($id);
        $technicians = WorkOrderStaff::getTechnician($id);
        $inspector = WorkOrderStaff::getInspector($id);

        $workPreliminary = WorkPreliminary::getWorkPreliminary($id,$work_order_part_id);
        $hiddenDamage = WorkHiddenDamage::getWorkHiddenDamage($id,$work_order_part_id);
        $att = WorkOrderAttachment::getWorkOrderAttachmentR($id,$work_order_part_id);

        return $this->render('print-receiving', [
            'model' => $model,
            'att' => $att,
            'supervisor' => $supervisor,
            'finalInspector' => $finalInspector,
            'inspector' => $inspector,
            'technicians' => $technicians,
            'workPreliminary' => $workPreliminary,
            'hiddenDamage' => $hiddenDamage,
            'workOrderPart' => $workOrderPart,
        ]);
    }

    /**
     * print disposition report
     * @param integer $id
     * @return mixed
     */
    public function actionPrintDisposition($id,$work_order_part_id)
    {
        $this->layout = 'print';
        $model = $this->findModel($id);
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $supervisor = WorkOrderStaff::getSupervisor($id);
        $finalInspector = WorkOrderStaff::getFinalInspector($id);
        $technicians = WorkOrderStaff::getTechnician($id);
        $inspector = WorkOrderStaff::getInspector($id);
        $finalInspector = WorkOrderStaff::getFinalInspector($id);
        $disAttachment = WorkOrderAttachment::getWorkOrderAttachmentD($id,$work_order_part_id);
        $workPreliminary = WorkPreliminary::getWorkPreliminary($id,$work_order_part_id);
        $hiddenDamage = WorkHiddenDamage::getWorkHiddenDamage($id,$work_order_part_id);

        return $this->render('print-disposition', [
            'model' => $model,
            'supervisor' => $supervisor,
            'inspector' => $inspector,
            'finalInspector' => $finalInspector,
            'technicians' => $technicians,
            'hiddenDamage' => $hiddenDamage,
            'disAttachment' => $disAttachment,
            'workPreliminary' => $workPreliminary,
            'workOrderPart' => $workOrderPart,
        ]);
    }

    /**
     * print traveler
     * @param integer $id
     * @return mixed
     */
    public function actionPrintTraveler($id,$work_order_part_id)
    {
        $this->layout = 'print-traveler';
        $model = $this->findModel($id);
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $travelerId = $workOrderPart->traveler_id;
        $traveler = Traveler::find()->where(['id' => $travelerId])->one();

        $value = $traveler->value;
        return $this->redirect('uploads/traveler/'.$value);

        return $this->render('print-traveler', [
            'model' => $model,
            'traveler' => $traveler,
        ]);
    }
    /**
     * print repairable sticker
     * @param integer $id
     * @return mixed
     */
    public function actionRepairableSticker($id,$work_order_part_id)
    {
        $model = $this->findModel($id);
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        return $this->render('repairable-sticker', [
            'model' => $model,
            'workOrderPart' => $workOrderPart,
        ]);
    }

    /**
     * print final inspection
     * @param integer $id
     * @return mixed
     */
    public function actionPrintFinal($id,$work_order_part_id)
    {
        $this->layout = 'print';
        $model = $this->findModel($id);
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        return $this->render('print-final', [
            'model' => $model,
            'workOrderPart' => $workOrderPart,
        ]);
    }
    /**
     * print final inspection sticker
     * @param integer $id
     * @return mixed
     */
    public function actionFinalSticker($id,$work_order_part_id)
    {
        $model = $this->findModel($id);
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        return $this->render('final-sticker', [
            'model' => $model,
            'workOrderPart' => $workOrderPart,
        ]);
    }

    /**
     * print CAA
     * @param integer $id
     * @return mixed
     */
    public function actionPrintCaa($id)
    {
        $this->layout = 'print';
        $model = $this->findModel($id);
        return $this->render('print-caa', [
            'model' => $model,
        ]);
    }

    /**
     * print BOM
     * @param integer $id work order id
     * @return mixed
     */
    public function actionPrintBom($id,$work_order_part_id)
    {
        $this->layout = 'print';
        $model = $this->findModel($id);
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $WorkStockRequisition = WorkStockRequisition::getWSRByWorkOrderId($id);

        return $this->render('print-bom', [
            'workStockRequisition' => $WorkStockRequisition,
            'model' => $model,
            'workOrderPart' => $workOrderPart,
        ]);
    }
    /**
     * print BOM
     * @param integer $id work order id
     * @return mixed
     */
    public function actionPrintMrf($id,$work_order_part_id)
    {
        $this->layout = 'print';
        $model = $this->findModel($id);
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $WorkStockRequisition = WorkStockRequisition::getWSRByWorkOrderId($id);

        return $this->render('print-mrf', [
            'WorkStockRequisition' => $WorkStockRequisition,
            'model' => $model,
            'workOrderPart' => $workOrderPart,
        ]);
    }


/**
*  ajax function
*/

    /* to enable ajax function */
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * AJAX FUNCTION.
     */
    public function actionGetTemplate()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $partNoTemp = Yii::$app->request->post()['partNoTemp'];
            $query = "SELECT id FROM template WHERE part_no LIKE '%$partNoTemp%' OR alternative LIKE '%$partNoTemp%' OR remark LIKE '%$partNoTemp%';";
            $template = Yii::$app->db->createCommand($query)->queryOne();
            if ( $template ) {
                $id = $template['id'];
                return json_encode($id);
            }
            return json_encode(false);
        }
    }


    /**
     * AJAX FUNCTION.
     */
    public function actionGetDesc()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $partNoTemp = Yii::$app->request->post()['partNoTemp'];
            $data = [];
            $capability = Capability::find()->where( ['part_no' => $partNoTemp ] )->one();
            if ( $capability ) {
                $data['description'] = $capability->description;
                $data['manufacturer'] = $capability->manufacturer;
                return json_encode($data);
            } else {
                return false;
            }
        }
    }


    /**
     * AJAX FUNCTION.
     */
    public function actionGetTechnician()
    {
        $this->layout = false;
        // if ( Yii::$app->request->post() ) {
            $staffTechnician = Staff::find()->where(['<>','status','inactive'])->all();
            return $this->render('get-technician', [
                'staffTechnician' => $staffTechnician,
            ]);
        // }
    }


    /**
     * AJAX FUNCTION.
     */
    public function actionAjaxGetfinal()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $postData = Yii::$app->request->post();
            $finalId = $postData['selection'];
            $getContent = FinalInspection::find()->where(['id' => $finalId ])->one();
            if ( $getContent ) {
                $data['content'] = $getContent->content;
                $data['title'] = $getContent->title;
                $data['form_no'] = $getContent->form_no;
                return json_encode($data);
            } else {
                return false;
            }
        }
    }
    /**
     * AJAX FUNCTION.
     */
    public function actionAddDiscrepancy()
    {
        $this->layout = false;
        return $this->render('add-discrepancy');
    }

    /**
     * AJAX FUNCTION.
     */
    public function actionAddHdiscrepancy()
    {
        $this->layout = false;
        $getStaff = Staff::find()->where(['<>','status',0])->all();
        return $this->render('add-hdiscrepancy',['getStaff' => $getStaff]);
    }

    /**
     * AJAX FUNCTION.
     */
    public function actionUpdateStatus()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $dataPost = Yii::$app->request->post();
            $workorderids = $dataPost['workorderids'];
            $status = $dataPost['status'];
            foreach ( $workorderids as $workOrderId ) {
                if ( !empty ($workOrderId) ) {
                    $workOrder = WorkOrder::getWorkOrder($workOrderId);
                    $workOrder->status = $status;
                    $workOrder->save();
                }
            } /* foreach */
        }
        Yii::$app->getSession()->setFlash('success', 'Status Updated!');

        return true;

    }

/**
*  stock required
*/
    /**
     * Stock out
     * @param integer $id
     * @return mixed
     */
    public function actionRequisition($id,$work_order_part_id)
    {
        $stockQuery = $this->getStockQuantity();
        $requisition = new WorkStockRequisition();
        $currRequisition = WorkStockRequisition::getWSRByWorkOrderPartId($work_order_part_id);

        if ( $requisition->load(Yii::$app->request->post() ) ) {
            // d(Yii::$app->request->post());exit;
            WorkOrder::saveStockUsed($requisition,$id,$work_order_part_id);
            Yii::$app->getSession()->setFlash('success', 'Parts Required Updated!');
            return $this->redirect(['requisition','id' => $id,'work_order_part_id' => $work_order_part_id]);
        }
        return $this->render('requisition', [
            'stockQuery' => $stockQuery,
            'requisition' => $requisition,
            'currRequisition' => $currRequisition,
        ]);
    }


    public function getStockQuantity() {

        $dataUnit = ArrayHelper::map(Unit::find()->where(['status' => 'active'])->all(), 'id', 'unit');
        $dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');

        $sqlQuery = "
                    SELECT
                        s.id,
                        s.part_id,
                        p.part_no
                    FROM
                        stock s,
                        part p
                    WHERE
                        s.part_id = p.id AND
                        s.status = 'active'
                    GROUP by
                        s.part_id
                ";

        $stockQuery = Yii::$app->db->createCommand($sqlQuery)->queryAll();
        // d($stockQuery);exit;
        /* custom sql query for grand total only */
            foreach ( $stockQuery as $key => $sQ){
                $partId = $sQ['part_id'];
                $sqlQueryTotal = "
                            SELECT
                                sum(quantity) sumsQ,
                                unit_id
                            FROM
                                stock s
                            WHERE
                                s.status = 'active' AND
                                s.part_id = $partId
                        ";
                $stockQtyTotal = Yii::$app->db->createCommand($sqlQueryTotal)->queryOne();
                $stockQuery[$key]['sumsQ'] = number_format($stockQtyTotal['sumsQ'], 3, '.', '');
                $stockQuery[$key]['unit_id'] = $dataUnit[$stockQtyTotal['unit_id']];
            }

            return $stockQuery;

    }


/**
*  stock issue
*/

       /**
     * Stock out
     * @param integer $id
     * @return mixed
     */
    public function actionIssue($id,$work_order_part_id)
    {
        $stockQuery = $this->getStockQuantity();
        $req = new WorkStockRequisition();
        $requisition = WorkStockRequisition::getWSRByWorkOrderPartId($work_order_part_id);
        if ( $req->load(Yii::$app->request->post() ) ) {
            WorkOrder::saveStockIssued($req,$id,$work_order_part_id);
            Yii::$app->getSession()->setFlash('success', 'Parts Issued! Stock Deducted');
            return $this->redirect(['pick-list','id' => $id,'work_order_part_id' => $work_order_part_id]);
        }
        return $this->render('issue', [
            'req' => $req,
            'stockQuery' => $stockQuery,
            'requisition' => $requisition,
        ]);
    }

    public function actionPickList($id,$work_order_part_id){
        $this->layout = 'print';
        $stockQuery = $this->getStockQuantity();
        $model = $this->findModel($id);
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $workStockRequisition = WorkStockRequisition::getWSRByWorkOrderPartId($work_order_part_id);
        return $this->render('pick-list', [
            'workStockRequisition' => $workStockRequisition,
            'workOrderPart' => $workOrderPart,
            'model' => $model,
            'stockQuery' => $stockQuery,
        ]);
    }

/**
*  stock in
*/
    /**
     * Stock out
     * @param integer $id
     * @return mixed
     */
    public function actionReturn($id,$work_order_part_id)
    {
        $stockQuery = $this->getStockQuantity();
        $requisition = false;
        $req = new WorkStockRequisition();
        $requisition = WorkStockRequisition::getWSRByWorkOrderPartId($work_order_part_id);
        if ( $req->load(Yii::$app->request->post() ) ) {
            // dx(Yii::$app->request->post());
            WorkOrder::saveStockReturned($req,$id,$work_order_part_id);
            Yii::$app->getSession()->setFlash('success', 'Parts Returned!');
            return $this->redirect(['return','id' => $id,'work_order_part_id' => $work_order_part_id]);
        }

        return $this->render('return', [
            'requisition' => $requisition,
            'stockQuery' => $stockQuery,
            'req' => $req,
        ]);
    }


    /**
     * save stock id
     *
     */

    public function actionSaveStockid()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $postData = Yii::$app->request->post();
            $stockid = $postData['stockid'];
            $reqid = $postData['reqid'];

            $wsr = WorkStockRequisition::getWSRbyId($reqid);
            $wsr->stock_id = $stockid;
            $wsr->save();

            return true;
        }
    }

    /**
     * save stock id
     *
     */

    public function actionSearchPart()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $postData = Yii::$app->request->post();
            $partNoKeyed = $postData['partNoKeyed'];
            $getCapability = Capability::find()->where( ['LIKE','part_no', $partNoKeyed ] )
                                        ->andWhere(['<>','deleted','1'])
                                        ->limit(5)
                                        ->all();
        }
        return $this->render('search-part', [
            'getCapability' => $getCapability,
        ]);
    }

    public function actionGetChecklist()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $postData = Yii::$app->request->post();
            $work_order_part_id = $postData['work_order_part_id'];
            $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
            $is_processing = $workOrderPart['is_processing'];
            $is_receiving = $workOrderPart['is_receiving'];
            $is_preliminary = $workOrderPart['is_preliminary'];
            $is_hidden = $workOrderPart['is_hidden'];
            $is_traveler = $workOrderPart['is_traveler'];
            $is_final = $workOrderPart['is_final'];

            return $this->render('get-checklist', [
                'work_order_part_id' => $work_order_part_id,
                'is_processing' => $is_processing,
                'is_receiving' => $is_receiving,
                'is_preliminary' => $is_preliminary,
                'is_hidden' => $is_hidden,
                'is_traveler' => $is_traveler,
                'is_final' => $is_final,
            ]);
        }
    }
    public function actionAddPart()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $postData = Yii::$app->request->post();
            return $this->render('add-part', [
                'data' => $postData,
            ]);
        }
    }

    /**
     * Move quarantined parts back to  the work order status, temporarily set status back to pending
     * Parts created at quarantined table is deleted
     */
    public function actionRemoveQuarantined($work_order_part_id){
        $part = WorkOrderPart::find()->where(['id'=>$work_order_part_id])->one();
        $part->status = 'pending';
        $part->save(false);
        $qua =Quarantine::find()->where(['work_order_part_id'=>$work_order_part_id])->one();
        $qua->delete();
      //  $qua->save(false);
        Yii::$app->getSession()->setFlash('success', 'Part removed from quarantined!');
        return $this->redirect(['preview', 'id' => $part->work_order_id]);
    }

    /*
    * Set selected part to returned. Just like scrapped, cannot be undone as it has been set
    */
    public function actionReturnBack($work_order_part_id){
        $part = WorkOrderPart::find()->where(['id'=>$work_order_part_id])->one();
        $part->status = 'returned';
        $part->save(false);
        Yii::$app->getSession()->setFlash('success', 'Part returned to customer');
        return $this->redirect(['preview', 'id' => $part->work_order_id]);
    }


}
