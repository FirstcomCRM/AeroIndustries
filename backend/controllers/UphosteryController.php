<?php

namespace backend\controllers;

use Yii;
use common\models\Uphostery;
use common\models\SearchUphostery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\UphosteryPart;
use common\models\Template;
use common\models\UphosteryArc;
use common\models\UphosteryHiddenDamage;
use common\models\WoFinalAttachment;
use common\models\WoPreAttachment;
use common\models\WoDispositionAttachment;
use common\models\UphosteryAttachment;
use common\models\UphosteryStaff;
use common\models\UphosteryStockRequisition;
use common\models\UphosteryPreliminary;
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
 * UphosteryController implements the CRUD actions for Uphostery model.
 */
class UphosteryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');

        foreach ( $userGroupArray as $uGId => $uGName ){
            $permission = UserPermission::find()->where(['controller' => 'Uphostery'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all Uphostery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUphostery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Deletes an existing Uphostery model.
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
     * Finds the Uphostery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Uphostery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Uphostery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



/* custom  */
    /**
     * Creates a new Uphostery .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew()
    {
        $model = new Uphostery();
        $woAttachment = new UphosteryAttachment();
        $uphosteryPart = new UphosteryPart();
        $staff = new UphosteryStaff();

        $data['model'] = $model;
        $data['woAttachment'] = $woAttachment;
        $data['uphosteryPart'] = $uphosteryPart;
        $data['gotTemplate'] = false;
        $data['staff'] = $staff;
        $session = Yii::$app->session;
        if ( $model->load( Yii::$app->request->post() ) ) {
            // dx(Yii::$app->request->post());
                $uphosteryPart->load(Yii::$app->request->post());
                $uphosteryId = Uphostery::saveWo($model);
                $this->saveStaff($staff,$uphosteryId);
                UphosteryPart::saveWo($uphosteryPart,$uphosteryId);
                Yii::$app->getSession()->setFlash('success', 'Uphostery Created!');
                return $this->redirect(['preview', 'id' => $model->id]);
        }
        return $this->render('new', [
            'data' => $data
        ]);
    }

    /**f
     * Edit an existing Uphostery .
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $data = array();
        $model = $this->findModel($id);
        $uphosteryPart = new UphosteryPart();
        $euphosteryPart = UphosteryPart::getUphosteryPart($id);
        $uphosteryId = $id;
        $woAttachment = new UphosteryAttachment();
        $staff = new UphosteryStaff();
        $finalInspector = UphosteryStaff::getFinalInspector($uphosteryId);
        $inspector = UphosteryStaff::getInspector($uphosteryId);
        $supervisor = UphosteryStaff::getSupervisor($uphosteryId);
        $technician = UphosteryStaff::getTechnician($uphosteryId);
        $UphosteryStockRequisition = UphosteryStockRequisition::getWSRByUphosteryId($id);
        /* templte */
        $gotTemplate = false;
        $data['model'] = $model;
        $data['woAttachment'] = $woAttachment;
        $data['staff'] = $staff;
        $data['inspector'] = $inspector;
        $data['finalInspector'] = $finalInspector;
        $data['supervisor'] = $supervisor;
        $data['technician'] = $technician;
        $data['uphosteryPart'] = $uphosteryPart;
        $data['euphosteryPart'] = $euphosteryPart;
        $data['gotTemplate'] = $gotTemplate;
        $data['UphosteryStockRequisition'] = $UphosteryStockRequisition;

        if ( $model->load( Yii::$app->request->post() ) ) {
            // dx(Yii::$app->request->post());exit;
            $model->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->updated = $currentDateTime;
            if ( $model->save() ) {
                $uphosteryPart->load(Yii::$app->request->post());
                UphosteryPart::saveWo($uphosteryPart,$id);
                $this->saveStaff($staff,$id);
                Yii::$app->getSession()->setFlash('success', 'Uphostery Updated!');
                return $this->redirect(['preview', 'id' => $model->id]);
            }
            /* after save, proceed to next part */
            /* allow them to assign parts for fix later */
            Yii::$app->getSession()->setFlash('success', 'Uphostery Created! Please fill up the bill of material');
            return $this->redirect(['index']);
        }
        return $this->render('edit', [
            'data' => $data,
        ]);
    }
    public function actionProcessingInspection($id,$uphostery_part_id){

        $model = $this->findModel($id);
        $woAttachment = new UphosteryAttachment();
        $uphosteryPart = new UphosteryPart();
        $euphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $currPoAtt = UphosteryAttachment::getUphosteryAttachmentPI($id,$uphostery_part_id);

        $data['model'] = $model;
        $data['euphosteryPart'] = $euphosteryPart;
        $data['uphosteryPart'] = $uphosteryPart;
        $data['woAttachment'] = $woAttachment;
        $data['currPoAtt'] = $currPoAtt;

        if ( $woAttachment->load(Yii::$app->request->post()) ) {
            // dx(Yii::$app->request->post());
            $this->saveWoAttachment($woAttachment, $id,$uphostery_part_id);

            Yii::$app->getSession()->setFlash('success', 'Processing Inspection Updated!');
            return $this->redirect(['preview', 'id' => $model->id]);
        }

        return $this->render('processing-inspection', [
            'data' => $data,
        ]);
    }
    public function actionReceivingInspection($id,$uphostery_part_id){

        $model = $this->findModel($id);
        $woAttachment = new UphosteryAttachment();
        $uphosteryPart = new UphosteryPart();
        $euphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $currWoAtt = UphosteryAttachment::getUphosteryAttachmentW($id,$uphostery_part_id);

        $data['model'] = $model;
        $data['euphosteryPart'] = $euphosteryPart;
        $data['uphosteryPart'] = $uphosteryPart;
        $data['woAttachment'] = $woAttachment;
        $data['currWoAtt'] = $currWoAtt;

        if ( $euphosteryPart->load(Yii::$app->request->post()) ) {
            // dx(Yii::$app->request->post());
            $euphosteryPart->created_by = Yii::$app->user->identity->id;
            $this->saveWoAttachment($woAttachment, $id,$uphostery_part_id);
            $currentDateTime = date("Y-m-d H:i:s");
            $euphosteryPart->created = $currentDateTime;
            $euphosteryPart->save();

            Yii::$app->getSession()->setFlash('success', 'Receiving Inspection Updated!');
            return $this->redirect(['preview', 'id' => $model->id]);
        }

        return $this->render('receiving-inspection', [
            'data' => $data,
        ]);
    }
    public function actionPreliminaryInspection($id,$uphostery_part_id){

        $model = $this->findModel($id);
        $woAttachment = new UphosteryAttachment();
        $uphosteryPart = new UphosteryPart();
        $euphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $currPreAtt = UphosteryAttachment::getUphosteryAttachmentP($id,$uphostery_part_id);
        $currDisAtt = UphosteryAttachment::getUphosteryAttachmentD($id,$uphostery_part_id);
        $uphosteryPreliminary = UphosteryPreliminary::getUphosteryPreliminary($id,$uphostery_part_id);
        if ( ! $uphosteryPreliminary ) {
            $uphosteryPreliminary = new UphosteryPreliminary();
        }

        $data['model'] = $model;
        $data['euphosteryPart'] = $euphosteryPart;
        $data['uphosteryPart'] = $uphosteryPart;
        $data['woAttachment'] = $woAttachment;
        $data['currPreAtt'] = $currPreAtt;
        $data['currDisAtt'] = $currDisAtt;

        $data['uphosteryPreliminary'] = $uphosteryPreliminary;

        if ( $euphosteryPart->load(Yii::$app->request->post()) ) {
            $euphosteryPart->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $euphosteryPart->updated = $currentDateTime;
            $euphosteryPart->save();
            $this->savePreliminary($uphosteryPreliminary,$id, $uphostery_part_id);
            $this->saveWoAttachment($woAttachment, $id,$uphostery_part_id);

            Yii::$app->getSession()->setFlash('success', 'Preliminary Inspection Updated!');
            return $this->redirect(['preview', 'id' => $model->id]);
        }

        return $this->render('preliminary-inspection', [
            'data' => $data,
        ]);
    }
    public function actionHiddenDamage($id,$uphostery_part_id){

        $model = $this->findModel($id);
        $woAttachment = new UphosteryAttachment();
        $uphosteryPart = new UphosteryPart();
        $euphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $currHidAtt = UphosteryAttachment::getUphosteryAttachmentH($id,$uphostery_part_id);
        $hiddenDamage = UphosteryHiddenDamage::getUphosteryHiddenDamage($id,$uphostery_part_id);
        if ( ! $hiddenDamage ) {
            $hiddenDamage = new UphosteryHiddenDamage();
        }
        $data['model'] = $model;
        $data['euphosteryPart'] = $euphosteryPart;
        $data['uphosteryPart'] = $uphosteryPart;
        $data['woAttachment'] = $woAttachment;
        $data['currHidAtt'] = $currHidAtt;
        $data['hiddenDamage'] = $hiddenDamage;

        if ( $euphosteryPart->load(Yii::$app->request->post()) ) {
            $euphosteryPart->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $euphosteryPart->updated = $currentDateTime;
            $euphosteryPart->save();
            $this->saveHiddenDamage($hiddenDamage,$id, $uphostery_part_id);
            $this->saveWoAttachment($woAttachment, $id,$uphostery_part_id);

            Yii::$app->getSession()->setFlash('success', 'Hidden Damage Inspection Updated!');
            return $this->redirect(['preview', 'id' => $model->id]);
        }

        return $this->render('hidden-damage', [
            'data' => $data,
        ]);
    }
    public function actionUphosterySheet($id,$uphostery_part_id){

        $model = $this->findModel($id);
        $woAttachment = new UphosteryAttachment();
        $uphosteryPart = new UphosteryPart();
        $euphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $currWSAtt = UphosteryAttachment::getUphosteryAttachmentS($id,$uphostery_part_id);

        $data['model'] = $model;
        $data['euphosteryPart'] = $euphosteryPart;
        $data['uphosteryPart'] = $uphosteryPart;
        $data['woAttachment'] = $woAttachment;
        $data['currWSAtt'] = $currWSAtt;

        if ( $euphosteryPart->load(Yii::$app->request->post()) ) {
            $euphosteryPart->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $euphosteryPart->updated = $currentDateTime;
            $euphosteryPart->save();
            $this->saveWoAttachment($woAttachment, $id,$uphostery_part_id);

            Yii::$app->getSession()->setFlash('success', 'Uphostery Sheet Updated!');
            return $this->redirect(['preview', 'id' => $model->id]);
        }

        return $this->render('uphostery-sheet', [
            'data' => $data,
        ]);
    }

/* saving function */
        public function saveWoAttachment($woAttachment,$uphosteryId,$uphosteryPartId){
            if ( $woAttachment->load(Yii::$app->request->post()) ) {
                $woAttachment->attachment = UploadedFile::getInstances($woAttachment, 'attachment[uphostery]');
                foreach ($woAttachment->attachment as $file) {
                    $fileName = md5(date("YmdHis")).'-'.$file->name;
                    $qAttachmentClass = explode('\\', get_class($woAttachment))[2];
                    $file->saveAs('uploads/uphostery/'.$fileName);
                    /* image upload */
                    $woA = new UphosteryAttachment();
                    $woA->uphostery_id = $uphosteryId;
                    $woA->uphostery_part_id = $uphosteryPartId;
                    $woA->type = 'uphostery';
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
                    $woA = new UphosteryAttachment();
                    $woA->uphostery_id = $uphosteryId;
                    $woA->uphostery_part_id = $uphosteryPartId;
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
                    $woA = new UphosteryAttachment();
                    $woA->uphostery_id = $uphosteryId;
                    $woA->uphostery_part_id = $uphosteryPartId;
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
                    $woA = new UphosteryAttachment();
                    $woA->uphostery_id = $uphosteryId;
                    $woA->uphostery_part_id = $uphosteryPartId;
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
                    $woA = new UphosteryAttachment();
                    $woA->uphostery_id = $uphosteryId;
                    $woA->uphostery_part_id = $uphosteryPartId;
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
                    $woA = new UphosteryAttachment();
                    $woA->uphostery_id = $uphosteryId;
                    $woA->uphostery_part_id = $uphosteryPartId;
                    $woA->type = 'traveler';
                    $woA->value = $fileName;
                    $woA->created_by = Yii::$app->user->identity->id;
                    $currentDateTime = date("Y-m-d H:i:s");
                    $woA->created = $currentDateTime;
                    $woA->save();
                }

            }
        }
        public function saveHiddenDamage($hiddenDamage,$uphosteryId,$uphosteryPartId){
            UphosteryHiddenDamage::deleteAll(['uphostery_id' => $uphosteryId, 'uphostery_part_id' => $uphosteryPartId, ]);
            if ( Yii::$app->request->post()['UphosteryHiddenDamage'] ) {
                $hiddenDamage = Yii::$app->request->post()['UphosteryHiddenDamage'];
                $hiddenDiscrepancy = $hiddenDamage['discrepancy'];
                $hiddenCorrective = $hiddenDamage['corrective'];
                foreach ( $hiddenDiscrepancy as $key => $preliD ) {
                    if ( !empty ( $preliD ) ) {
                        $newWP = new UphosteryHiddenDamage();
                        $newWP->uphostery_id = $uphosteryId;
                        $newWP->uphostery_part_id = $uphosteryPartId;
                        $newWP->discrepancy = $preliD;
                        $newWP->corrective = $hiddenCorrective[$key];
                        $newWP->created_by = Yii::$app->user->identity->id;
                        $currentDateTime = date("Y-m-d H:i:s");
                        $newWP->created = $currentDateTime;
                        $newWP->save();
                        $hiddenDamageId = $newWP->id;

                        $this->saveHiddenDamageAttachment($key,$hiddenDamageId,$uphosteryId,$uphosteryPartId);
                    }
                }
            }
        }
        /* the uphostery order id will be representing hidden damage id in this case */
        public function saveHiddenDamageAttachment($key,$hiddenDamageId,$uphosteryId,$uphosteryPartId) {

            $woAttachment = new UphosteryAttachment();
            if ( $woAttachment->load(Yii::$app->request->post()) ) {
                $woAttachment->attachment = UploadedFile::getInstances($woAttachment, "attachment[hidden_damage][$key]");
                foreach ($woAttachment->attachment as $file) {
                    $fileName = md5(date("YmdHis")).'-'.$file->name;
                    $qAttachmentClass = explode('\\', get_class($woAttachment))[2];
                    $file->saveAs('uploads/hidden_damage/'.$fileName);
                    /* image upload */
                    $woA = new UphosteryAttachment();
                    $woA->uphostery_id = $uphosteryId;
                    $woA->uphostery_part_id = $uphosteryPartId;
                    $woA->type = 'hidden_damage';
                    $woA->value = $fileName;
                    $woA->created_by = Yii::$app->user->identity->id;
                    $currentDateTime = date("Y-m-d H:i:s");
                    $woA->created = $currentDateTime;
                    $woA->save();
                }
            }
        }
        public function saveStaff($staff,$uphosteryId){
            UphosteryStaff::deleteAll(['uphostery_id' => $uphosteryId]);
            if ( $staff->load( Yii::$app->request->post() ) ) {
                foreach ( $staff->staff_name as $key => $stf ) {
                    $staffName = $stf;
                    $staffType = $staff->staff_type[$key];
                    $woS = new UphosteryStaff();
                    $woS->uphostery_id = $uphosteryId;
                    $woS->staff_type = $staffType;
                    $woS->staff_name = $staffName;
                    $woS->created_by = Yii::$app->user->identity->id;
                    $currentDateTime = date("Y-m-d H:i:s");
                    $woS->created = $currentDateTime;
                    $woS->save();
                }
            }
        }
        public function savePreliminary($uphosteryPreliminary,$uphosteryId,$uphosteryPartId){
            UphosteryPreliminary::deleteAll(['uphostery_id' => $uphosteryId, 'uphostery_part_id' => $uphosteryPartId, ]);
            if ( Yii::$app->request->post()['UphosteryPreliminary'] ) {
                $uphosteryPreliminary = Yii::$app->request->post()['UphosteryPreliminary'];
                $preliDiscrepancy = $uphosteryPreliminary['discrepancy'];
                $preliCorrective = $uphosteryPreliminary['corrective'];
                foreach ( $preliDiscrepancy as $key => $preliD ) {
                    if ( !empty ( $preliD ) ) {
                        $newWP = new UphosteryPreliminary();
                        $newWP->uphostery_id = $uphosteryId;
                        $newWP->uphostery_part_id = $uphosteryPartId;
                        $newWP->discrepancy = $preliD;
                        $newWP->corrective = $preliCorrective[$key];
                        $newWP->save();
                    }
                }
            }
        }
        public function saveUphosteryStockRequisition($uphosteryId){
            d(Yii::$app->request->post());exit;
            if ( isset(Yii::$app->request->post()['used']) ){
                $useds = Yii::$app->request->post()['used'];
                foreach ( $useds as $wPUId => $used ) {
                    $UphosteryStockRequisition = UphosteryStockRequisition::getOneUphosteryStockRequisition($wPUId);
                    $UphosteryStockRequisition->qty_used = $used;
                    $UphosteryStockRequisition->save();
                }
            }
        }


    /**
     * Displays a single Uphostery .
     * @param integer $id
     * @return mixed
     */
    public function actionPreview($id)
    {
        // $uphosteryPreliminary = UphosteryPreliminary::getUphosteryPreliminary($id);
        // $hiddenDamage = UphosteryHiddenDamage::getUphosteryHiddenDamage($id);
        // $currWoAtt = UphosteryAttachment::getUphosteryAttachmentW($id);
        // $currPreAtt = UphosteryAttachment::getUphosteryAttachmentP($id);
        // $currDisAtt = UphosteryAttachment::getUphosteryAttachmentD($id);
        // $currFinalAtt = UphosteryAttachment::getUphosteryAttachmentF($id);
        $UphosteryStockRequisition = UphosteryStockRequisition::getWSRByUphosteryId($id);
        $uphosteryParts = UphosteryPart::getUphosteryPart($id);
        foreach($uphosteryParts as $uphosteryPart):
            $uphosteryArc[$uphosteryPart->id] = UphosteryArc::getUphosteryArc($id,$uphosteryPart->id);
        endforeach;
        $model = $this->findModel($id);
        $customer = Customer::getCustomer($model->customer_id);
        $supervisor = UphosteryStaff::getSupervisor($id);
        $finalInspector = UphosteryStaff::getFinalInspector($id);
        $technician = UphosteryStaff::getTechnician($id);
        $inspector = UphosteryStaff::getInspector($id);


        if ( Yii::$app->request->post() ){
            $postData = Yii::$app->request->post();
            $uphostery_part_id = $postData['uphostery_part_id'];
            $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
            $checklist = $postData['checklist'];
            $length = count($checklist);
            $uphosteryPart->is_processing = 0;
            $uphosteryPart->is_receiving = 0;
            $uphosteryPart->is_preliminary = 0;
            $uphosteryPart->is_hidden = 0;
            $uphosteryPart->is_traveler = 0;
            $uphosteryPart->is_final = 0;
            foreach ( $checklist as $key => $c ) {

                $uphosteryPart[$key] = 1;
            }
            if ( $length == 6 ) {
                $uphosteryPart->status = 'Completed';
            } else {
                $uphosteryPart->status = 'Pending';
            }
            $uphosteryPart->save();
            return $this->redirect(['preview','id' => $id]);
        }

        return $this->render('preview', [
            'model' => $model,
            'uphosteryArc' => $uphosteryArc,
            'supervisor' => $supervisor,
            'inspector' => $inspector,
            'finalInspector' => $finalInspector,
            'technician' => $technician,
            'customer' => $customer,
            // 'currPreAtt' => $currPreAtt,
            // 'currDisAtt' => $currDisAtt,
            // 'currWoAtt' => $currWoAtt,
            // 'hiddenDamage' => $hiddenDamage,
            // 'uphosteryPreliminary' => $uphosteryPreliminary,
            'UphosteryStockRequisition' => $UphosteryStockRequisition,
            'uphosteryParts' => $uphosteryParts,
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
            Yii::$app->getSession()->setFlash('success', 'Uphostery Cancelled');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to cancel the Uphostery');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
    /**
     * remove wo attachment
     * @param integer $id = uphostery_attachment id
     * @return mixed
     */
    public function actionRemoveWoa($id)
    {
        $woa = UphosteryAttachment::find()->where( ['id' => $id] )->one();
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
     * print a single Uphostery .
     * @param integer $id
     * @return mixed
     */
    public function actionPrint($id,$uphostery_part_id)
    {
        $this->layout = 'print';
        $model = $this->findModel($id);
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $supervisor = UphosteryStaff::getSupervisor($id);
        $finalInspector = UphosteryStaff::getFinalInspector($id);
        $technicians = UphosteryStaff::getTechnician($id);
        $inspector = UphosteryStaff::getInspector($id);

        $uphosteryPreliminary = UphosteryPreliminary::getUphosteryPreliminary($id,$uphostery_part_id);
        $hiddenDamage = UphosteryHiddenDamage::getUphosteryHiddenDamage($id,$uphostery_part_id);

        $att = UphosteryAttachment::find()->where( ['uphostery_id' => $id] )->andWhere( ['type' => 'hidden_damage'] )->all();


        return $this->render('print', [
            'model' => $model,
            'att' => $att,
            'supervisor' => $supervisor,
            'finalInspector' => $finalInspector,
            'inspector' => $inspector,
            'technicians' => $technicians,
            'uphosteryPreliminary' => $uphosteryPreliminary,
            'hiddenDamage' => $hiddenDamage,
            'uphosteryPart' => $uphosteryPart,
        ]);
    }
    /**
     * print a single Uphostery .
     * @param integer $id
     * @return mixed
     */
    public function actionPrintReceiving($id,$uphostery_part_id)
    {
        $this->layout = 'print';
        $model = $this->findModel($id);
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $supervisor = UphosteryStaff::getSupervisor($id);
        $finalInspector = UphosteryStaff::getFinalInspector($id);
        $technicians = UphosteryStaff::getTechnician($id);
        $inspector = UphosteryStaff::getInspector($id);

        $uphosteryPreliminary = UphosteryPreliminary::getUphosteryPreliminary($id,$uphostery_part_id);
        $hiddenDamage = UphosteryHiddenDamage::getUphosteryHiddenDamage($id,$uphostery_part_id);

        $att = UphosteryAttachment::find()->where( ['uphostery_id' => $id] )->andWhere( ['type' => 'uphostery'] )->all();

        return $this->render('print-receiving', [
            'model' => $model,
            'att' => $att,
            'supervisor' => $supervisor,
            'finalInspector' => $finalInspector,
            'inspector' => $inspector,
            'technicians' => $technicians,
            'uphosteryPreliminary' => $uphosteryPreliminary,
            'hiddenDamage' => $hiddenDamage,
            'uphosteryPart' => $uphosteryPart,
        ]);
    }

    /**
     * print disposition report
     * @param integer $id
     * @return mixed
     */
    public function actionPrintDisposition($id,$uphostery_part_id)
    {
        $this->layout = 'print';
        $model = $this->findModel($id);
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $supervisor = UphosteryStaff::getSupervisor($id);
        $finalInspector = UphosteryStaff::getFinalInspector($id);
        $technicians = UphosteryStaff::getTechnician($id);
        $inspector = UphosteryStaff::getInspector($id);
        $finalInspector = UphosteryStaff::getFinalInspector($id);
        $disAttachment = UphosteryAttachment::getUphosteryAttachmentD($id,$uphostery_part_id);
        $uphosteryPreliminary = UphosteryPreliminary::getUphosteryPreliminary($id,$uphostery_part_id);
        $hiddenDamage = UphosteryHiddenDamage::getUphosteryHiddenDamage($id,$uphostery_part_id);

        return $this->render('print-disposition', [
            'model' => $model,
            'supervisor' => $supervisor,
            'inspector' => $inspector,
            'finalInspector' => $finalInspector,
            'technicians' => $technicians,
            'hiddenDamage' => $hiddenDamage,
            'disAttachment' => $disAttachment,
            'uphosteryPreliminary' => $uphosteryPreliminary,
            'uphosteryPart' => $uphosteryPart,
        ]);
    }

    /**
     * print traveler
     * @param integer $id
     * @return mixed
     */
    public function actionPrintTraveler($id,$uphostery_part_id)
    {
        $this->layout = 'print-traveler';
        $model = $this->findModel($id);
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $travelerId = $uphosteryPart->traveler_id;
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
    public function actionRepairableSticker($id,$uphostery_part_id)
    {
        $model = $this->findModel($id);
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        return $this->render('repairable-sticker', [
            'model' => $model,
            'uphosteryPart' => $uphosteryPart,
        ]);
    }

    /**
     * print final inspection
     * @param integer $id
     * @return mixed
     */
    public function actionPrintFinal($id,$uphostery_part_id)
    {
        $this->layout = 'print';
        $model = $this->findModel($id);
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        return $this->render('print-final', [
            'model' => $model,
            'uphosteryPart' => $uphosteryPart,
        ]);
    }
    /**
     * print final inspection sticker
     * @param integer $id
     * @return mixed
     */
    public function actionFinalSticker($id,$uphostery_part_id)
    {
        $model = $this->findModel($id);
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        return $this->render('final-sticker', [
            'model' => $model,
            'uphosteryPart' => $uphosteryPart,
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
     * @param integer $id uphostery order id
     * @return mixed
     */
    public function actionPrintBom($id,$uphostery_part_id)
    {
        $this->layout = 'print';
        $model = $this->findModel($id);
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $UphosteryStockRequisition = UphosteryStockRequisition::getWSRByUphosteryId($id);

        return $this->render('print-bom', [
            'uphosteryStockRequisition' => $UphosteryStockRequisition,
            'model' => $model,
            'uphosteryPart' => $uphosteryPart,
        ]);
    }
    /**
     * print BOM
     * @param integer $id uphostery order id
     * @return mixed
     */
    public function actionPrintMrf($id,$uphostery_part_id)
    {
        $this->layout = 'print';
        $model = $this->findModel($id);
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $UphosteryStockRequisition = UphosteryStockRequisition::getWSRByUphosteryId($id);

        return $this->render('print-mrf', [
            'UphosteryStockRequisition' => $UphosteryStockRequisition,
            'model' => $model,
            'uphosteryPart' => $uphosteryPart,
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
            $uphosteryids = $dataPost['uphosteryids'];
            $status = $dataPost['status'];
            foreach ( $uphosteryids as $uphosteryId ) {
                if ( !empty ($uphosteryId) ) {
                    $uphostery = Uphostery::getUphostery($uphosteryId);
                    $uphostery->status = $status;
                    $uphostery->save();
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
    public function actionRequisition($id,$uphostery_part_id)
    {
        $stockQuery = $this->getStockQuantity();
        $requisition = new UphosteryStockRequisition();
        $currRequisition = UphosteryStockRequisition::getWSRByUphosteryPartId($uphostery_part_id);

        if ( $requisition->load(Yii::$app->request->post() ) ) {
            // d(Yii::$app->request->post());exit;
            Uphostery::saveStockUsed($requisition,$id,$uphostery_part_id);
            Yii::$app->getSession()->setFlash('success', 'Parts Required Updated!');
            return $this->redirect(['requisition','id' => $id,'uphostery_part_id' => $uphostery_part_id]);
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
    public function actionIssue($id,$uphostery_part_id)
    {
        $stockQuery = $this->getStockQuantity();
        $req = new UphosteryStockRequisition();
        $requisition = UphosteryStockRequisition::getWSRByUphosteryPartId($uphostery_part_id);
        if ( $req->load(Yii::$app->request->post() ) ) {
            Uphostery::saveStockIssued($req,$id,$uphostery_part_id);
            Yii::$app->getSession()->setFlash('success', 'Parts Issued! Stock Deducted');
            return $this->redirect(['pick-list','id' => $id,'uphostery_part_id' => $uphostery_part_id]);
        }
        return $this->render('issue', [
            'req' => $req,
            'stockQuery' => $stockQuery,
            'requisition' => $requisition,
        ]);
    }

    public function actionPickList($id,$uphostery_part_id){
        $this->layout = 'print';
        $stockQuery = $this->getStockQuantity();
        $model = $this->findModel($id);
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $uphosteryStockRequisition = UphosteryStockRequisition::getWSRByUphosteryPartId($uphostery_part_id);
        return $this->render('pick-list', [
            'uphosteryStockRequisition' => $uphosteryStockRequisition,
            'uphosteryPart' => $uphosteryPart,
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
    public function actionReturn($id,$uphostery_part_id)
    {
        $stockQuery = $this->getStockQuantity();
        $requisition = false;
        $req = new UphosteryStockRequisition();
        $requisition = UphosteryStockRequisition::getWSRByUphosteryPartId($uphostery_part_id);
        if ( $req->load(Yii::$app->request->post() ) ) {
            // dx(Yii::$app->request->post());
            Uphostery::saveStockReturned($req,$id,$uphostery_part_id);
            Yii::$app->getSession()->setFlash('success', 'Parts Returned!');
            return $this->redirect(['return','id' => $id,'uphostery_part_id' => $uphostery_part_id]);
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

            $wsr = UphosteryStockRequisition::getWSRbyId($reqid);
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
            $uphostery_part_id = $postData['uphostery_part_id'];
            $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
            $is_processing = $uphosteryPart['is_processing'];
            $is_receiving = $uphosteryPart['is_receiving'];
            $is_preliminary = $uphosteryPart['is_preliminary'];
            $is_hidden = $uphosteryPart['is_hidden'];
            $is_traveler = $uphosteryPart['is_traveler'];
            $is_final = $uphosteryPart['is_final'];

            return $this->render('get-checklist', [
                'uphostery_part_id' => $uphostery_part_id,
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
     * Move quarantined parts back to  the uphostery order status, temporarily set status back to pending
     * Parts created at quarantined table is deleted
     */
    public function actionRemoveQuarantined($uphostery_part_id){
        $part = UphosteryPart::find()->where(['id'=>$uphostery_part_id])->one();
        $part->status = 'pending';
        $part->save(false);
        $qua =Quarantine::find()->where(['uphostery_part_id'=>$uphostery_part_id])->one();
        $qua->delete();
      //  $qua->save(false);
        Yii::$app->getSession()->setFlash('success', 'Part removed from quarantined!');
        return $this->redirect(['preview', 'id' => $part->uphostery_id]);
    }

    /*
    * Set selected part to returned. Just like scrapped, cannot be undone as it has been set
    */
    public function actionReturnBack($uphostery_part_id){
        $part = UphosteryPart::find()->where(['id'=>$uphostery_part_id])->one();
        $part->status = 'returned';
        $part->save(false);
        Yii::$app->getSession()->setFlash('success', 'Part returned to customer');
        return $this->redirect(['preview', 'id' => $part->uphostery_id]);
    }


}
