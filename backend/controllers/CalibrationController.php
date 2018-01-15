<?php

namespace backend\controllers;

use Yii;
use common\models\Calibration;
use common\models\SearchCalibration;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\Tool;
use common\models\Setting;

/**
 * CalibrationController implements the CRUD actions for Calibration model.
 */
class CalibrationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Calibration'])->andWhere(['user_group_id' => $uGId ] )->all();
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
 * CRUD
 */
        /**
         * Lists all Calibration models.
         * @return mixed
         */
        public function actionIndex()
        {
            $searchModel = new SearchCalibration();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

       

        /**
         * Finds the Calibration model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return Calibration the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = Calibration::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }



    /**
     * Creates a new Calibration .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew($id=null)
    {
        $model = new Calibration();
        $tool = false;
        $partId = false;
        $serialNo = false;

        if ( !empty($id) ) {
            $model->tool_id = $id;
            $tool = Tool::getTool($id);
            $partId = $tool->part_id;
            $serialNo = $tool->serial_no;
        }

        if ($model->load(Yii::$app->request->post()) ) {


            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;


            if ($model->save()) {
                return $this->redirect(['preview', 'id' => $model->id]);
            }
        } 
        return $this->render('new', [
            'model' => $model,
            'tool' => $tool,
            'partId' => $partId,
            'serialNo' => $serialNo,
        ]);
        
    }

    /**
     * Creates a new Calibration .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionMultiple()
    {
        $model = new Calibration();

        $tidSelected = Yii::$app->request->get()['tid'];

        $tidDetails = array();
        foreach ($tidSelected as $key => $tid) {
            $tool = Tool::getTool($tid);
            $tidDetails[$key]['part_id'] = $tool->part_id;
            $tidDetails[$key]['tool_id'] = $tid;
            $tidDetails[$key]['serial_no'] = $tool->serial_no;
        }

        if ($model->load(Yii::$app->request->post()) ) {
            // d(Yii::$app->request->post());exit;
            foreach ( $model->tool_id as $key => $tool_id):

                $cali = new Calibration();
                $cali->tool_id = $tool_id;
                $cali->description = $model->description[$key];
                $cali->manufacturer = $model->manufacturer[$key];
                $cali->model = $model->model[$key];
                $cali->serial_no = $model->serial_no[$key];
                $cali->storage_location = $model->storage_location[$key];
                $cali->con_approval = $model->con_approval[$key];
                $cali->acceptance_criteria = $model->acceptance_criteria[$key];
                $cali->date = $model->date[$key];
                $cali->due_date = $model->due_date[$key];
                $cali->created_by = Yii::$app->user->identity->id;
                $currentDateTime = date("Y-m-d H:i:s");
                $cali->created = $currentDateTime;
                $cali->save();

                $to = Tool::getTool($tool_id);
                $to->last_cali = $model->date[$key];
                $to->next_cali = $model->due_date[$key];
                $to->save();

            endforeach;

            return $this->redirect(['index']);
        } 
        return $this->render('multiple', [
            'model' => $model,
            'tidDetails' => $tidDetails,
        ]);
        
        
    }
    /**
     * Edit an existing Calibration .
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
  
    /**
     * Deletes an existing Calibration model by changing the delete status to 1 .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRemove($id)
    {
        $model = $this->findModel($id);
        $model->deleted = 1;
        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'Calibration deleted');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to delete Calibration');
        }

        return $this->redirect(['index']);
    }

}
