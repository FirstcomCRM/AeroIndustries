<?php

namespace backend\controllers;

use Yii;
use common\models\WorkOrderArc;
use common\models\SearchWorkOrderArc;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\WorkOrder;
use common\models\WorkOrderStaff;
use common\models\WorkOrderPart;


/**
 * WorkOrderArcController implements the CRUD actions for WorkOrderArc model.
 */
class WorkOrderArcController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'WorkOrderArc'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all WorkOrderArc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchWorkOrderArc();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
/**
 * CRUD
*/
        /**
         * Displays a single WorkOrderArc model.
         * @param integer $id
         * @return mixed
         */
        public function actsionView($id)
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }

        /**
         * Creates a new WorkOrderArc model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actsionCreate()
        {
            $model = new WorkOrderArc();

            if ($model->load(Yii::$app->request->post()) ) {

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } 
            return $this->render('create', [
                'model' => $model,
            ]);
            
        }

        /**
         * Updates an existing WorkOrderArc model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actisonUpdate($id)
        {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) ) {

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } 
            return $this->render('update', [
                'model' => $model,
            ]);
            
        }

        /**
         * Deletes an existing WorkOrderArc model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actisonDelete($id)
        {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }

        /**
         * Finds the WorkOrderArc model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return WorkOrderArc the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = WorkOrderArc::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }


/**
 * CUSTOM
*/
    /**
     * Creates a new WorkOrderArc .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actisonNew()
    {
        $model = new WorkOrderArc();

        if ($model->load(Yii::$app->request->post()) ) {

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } 
        return $this->render('new', [
            'model' => $model,
        ]);
        
    }

    /**
     * Edit an existing WorkOrderArc .
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actisonEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } 
        return $this->render('edit', [
            'model' => $model,
        ]);
        
    }

    /**
     * Displays a single WorkOrderArc .
     * @param integer $id
     * @return mixed
     */
    public function actisonPreview($id)
    {
        return $this->render('preview', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Deletes an existing WorkOrderArc model by changing the delete status to 1 .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actisonRemove($id)
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
     * Generate ARC .
     * @param integer $id = work order id 
     * @return mixed
     */
    public function actionGenerate($id,$work_order_part_id)
    {   
        $subTitle = 'Generate ARC';
        $workOrderId = $id;
        $model = new WorkOrderArc();
        $workOrder = WorkOrder::find()->where(['id' => $id])->one();
        $typeArr = [ 'EASA' => 'EASA', 'FAA' => 'FAA', 'CAAS' => 'CAAS', 'COC' => 'COC', 'CAAV' => 'CAAV', 'DCAM' => 'DCAM'];
        $dataType = [];
        foreach ( $typeArr as $key => $name ) {
            // $checkExistance = WorkOrderArc::find()->where(['type' => $key])->andWhere(['work_order_id' => $id])->exists();
            // if ( ! $checkExistance ) {
                $dataType[$key] = $key;
            // }
        }
        if ($model->load(Yii::$app->request->post()) ) {
            $type = $model->type; 
            $reprint = 0;
            $isGenerated = WorkOrderArc::find()->where(['work_order_id' => $workOrderId, 'work_order_part_id' => $work_order_part_id, 'type' => $type])->exists();
            if ( $isGenerated ){
                $existedARC = WorkOrderArc::find()->where(['work_order_id' => $workOrderId, 'work_order_part_id' => $work_order_part_id, 'type' => $type])->one();
                $reprint = $existedARC->reprint;
            }
            WorkOrderArc::deleteAll(['work_order_id' => $workOrderId, 'work_order_part_id' => $work_order_part_id, 'type' => $type]);
            if ( $type == 'CAAS') {
                $formTrackNo = 1;
                $fTN = WorkOrderArc::find()->where(['type' => $key])->orderBy('form_tracking_no DESC')->limit(1)->one();
                if ( !empty ( $fTN ) ) {
                    $previousNo = $fTN->form_tracking_no;
                    $formTrackNo = $previousNo+1;
                }
                // $model->form_tracking_no = $formTrackNo;
            } 
            $model->work_order_id = $workOrderId;
            $model->work_order_part_id = $work_order_part_id;
            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;
            if ( $isGenerated ) {
                if ($model->is_tracking_no){
                    $model->reprint = $reprint + 1;
                }
            }    
            if ( $model->save() ) {
                Yii::$app->getSession()->setFlash('success', "ARC for $type generated");
                return $this->redirect(['work-order/preview', 'id' => $workOrderId, 'work_order_part_id' => $work_order_part_id]);
            }
        } 
        return $this->render('generate', [
            'model' => $model,
            'subTitle' => $subTitle,
            'dataType' => $dataType,
        ]);
    }
    /**
     * print CAA
     * @param integer $id
     * @return mixed
     */
    public function actionPrintCaa($id,$work_order_part_id)
    {   
        $this->layout = 'print-arc';
        $model = WorkOrder::find()->where(['id' => $id])->one();
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $arc = WorkOrderArc::find()->where(['type' => 'CAAS'])->andWhere(['work_order_id' => $id])->one();
        $inspector = WorkOrderStaff::find()->where(['work_order_id' => $id])->andWhere(['staff_type' => 'final inspector'])->one();
        return $this->render('print-caa', [
            'workOrderPart' => $workOrderPart,
            'model' => $model,
            'arc' => $arc,
            'inspector' => $inspector,
        ]);
    }
    /**
     * print CAA
     * @param integer $id
     * @return mixed
     */
    public function actionPrintFaa($id,$work_order_part_id)
    {   
        $this->layout = 'print-arc';
        $model = WorkOrder::find()->where(['id' => $id])->one();
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $arc = WorkOrderArc::find()->where(['type' => 'FAA'])->andWhere(['work_order_id' => $id])->one();
        $inspector = WorkOrderStaff::find()->where(['work_order_id' => $id])->andWhere(['staff_type' => 'final inspector'])->one();
        return $this->render('print-faa', [
            'workOrderPart' => $workOrderPart,
            'model' => $model,
            'arc' => $arc,
            'inspector' => $inspector,
        ]);
    }
    /**
     * print CAA
     * @param integer $id
     * @return mixed
     */
    public function actionPrintEasa($id,$work_order_part_id)
    {   
        $this->layout = 'print-arc';
        $model = WorkOrder::find()->where(['id' => $id])->one();
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $arc = WorkOrderArc::find()->where(['type' => 'EASA'])->andWhere(['work_order_id' => $id])->one();
        $inspector = WorkOrderStaff::find()->where(['work_order_id' => $id])->andWhere(['staff_type' => 'final inspector'])->one();
        return $this->render('print-easa', [
            'workOrderPart' => $workOrderPart,
            'model' => $model,
            'arc' => $arc,
            'inspector' => $inspector,
        ]);
    }
    public function actionPrintCoc($id,$work_order_part_id)
    {   
        $this->layout = 'print-arc';
        $model = WorkOrder::find()->where(['id' => $id])->one();
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $arc = WorkOrderArc::find()->where(['type' => 'COC'])->andWhere(['work_order_id' => $id])->one();
        $inspector = WorkOrderStaff::find()->where(['work_order_id' => $id])->andWhere(['staff_type' => 'final inspector'])->one();
        return $this->render('print-coc', [
            'workOrderPart' => $workOrderPart,
            'model' => $model,
            'arc' => $arc,
            'inspector' => $inspector,
        ]);
    }
    public function actionPrintCaav($id,$work_order_part_id)
    {   
        $this->layout = 'print-arc';
        $model = WorkOrder::find()->where(['id' => $id])->one();
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $arc = WorkOrderArc::find()->where(['type' => 'CAAV'])->andWhere(['work_order_id' => $id])->one();
        $inspector = WorkOrderStaff::find()->where(['work_order_id' => $id])->andWhere(['staff_type' => 'final inspector'])->one();
        return $this->render('print-caav', [
            'workOrderPart' => $workOrderPart,
            'model' => $model,
            'arc' => $arc,
            'inspector' => $inspector,
        ]);
    }
    public function actionPrintDcam($id,$work_order_part_id)
    {   
        $this->layout = 'print-arc';
        $model = WorkOrder::find()->where(['id' => $id])->one();
        $workOrderPart = WorkOrderPart::getWorkOrderPartById($work_order_part_id);
        $arc = WorkOrderArc::find()->where(['type' => 'DCAM'])->andWhere(['work_order_id' => $id])->one();
        $inspector = WorkOrderStaff::find()->where(['work_order_id' => $id])->andWhere(['staff_type' => 'final inspector'])->one();
        return $this->render('print-dcam', [
            'workOrderPart' => $workOrderPart,
            'model' => $model,
            'arc' => $arc,
            'inspector' => $inspector,
        ]);
    }

}
