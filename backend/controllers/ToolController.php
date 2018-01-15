<?php

namespace backend\controllers;

use Yii;
use common\models\Tool;
use common\models\SearchTool;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\WorkPartUsed;
use common\models\Calibration;
use common\models\Setting;
use common\models\Unit;

/**
 * ToolController implements the CRUD actions for Tool model.
 */
class ToolController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Tool'])->andWhere(['user_group_id' => $uGId ] )->all();
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
 * crud
 */

        /**
         * Lists all Tool models.
         * @return mixed
         */
        public function actionIndex()
        {
            $searchModel = new SearchTool();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Finds the Tool model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return Tool the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = Tool::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }



    /**
     * Creates a new Tool .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew()
    {
        $model = new Tool();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } 
        return $this->render('new', [
            'model' => $model,
        ]);
        
    }

    /**
     * Edit an existing Tool .
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {

            $model->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->updated = $currentDateTime;

            
            if ($model->save()) {
                return $this->redirect(['preview', 'id' => $model->id]);
            }
        } 
        return $this->render('edit', [
            'model' => $model,
        ]);
        
    }

    /**
     * Displays a single Tool .
     * @param integer $id
     * @return mixed
     */
    public function actionPreview($id)
    {
        return $this->render('preview', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Deletes an existing Tool model by changing the delete status to 1 .
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
     * Tool Out .
     * @param integer $id
     * @return mixed
     */
    public function actionOut()
    {
        $workPartUsed = new WorkPartUsed();
        $t = Tool::getToolGroupByPart();

        if ($workPartUsed->load(Yii::$app->request->post()) ) {
            $workOrderId = $workPartUsed->work_order_id;
            $toolSelected = Yii::$app->request->post()['ToolSelected'];
            foreach ( $toolSelected as $partId => $noTaken) {
                if ( $noTaken > 0 ) {
                    $toolUpdate = Tool::find()
                    ->where(['part_id' => $partId])
                    ->andWhere(['status' => 1])
                    ->andWhere(['in_used' => 0])
                    ->limit($noTaken)
                    ->all();
                    
                    foreach ( $toolUpdate as $eachTool ) {
                        $eachTool->in_used = 1;
                        $eachTool->work_order_id = $workOrderId;
                        $eachTool->save();
                    }
                    Yii::$app->getSession()->setFlash('success', 'Tool Issued!');
                } else {
                    
                }
            }
            return $this->redirect(['out']);
        }
        return $this->render('out', [
            'workPartUsed' => $workPartUsed,
            't' => $t,
        ]);
    }


    /**
     * Lists all tool by parts.
     * @return mixed
     */
    public function actionTool()
    {
        /* filters */
            $filter = '';
            if ( isset( $_GET['cat_id'] ) && !empty ( $_GET['cat_id'] ) ) {
                $catId = $_GET['cat_id'];
                $filter .= " AND p.category_id = $catId ";
            }
            if ( isset( $_GET['part_id'] ) && !empty ( $_GET['part_id'] ) ) {
                $partId = $_GET['part_id'];
                $filter .= " AND p.id = $partId ";
            }

        $dataUnit = ArrayHelper::map(Unit::find()->where(['<>','status','inactive'])->all(), 'id', 'unit');
        /* custom sql query */
            $sqlQuery = "  
                        SELECT 
                            t.id,
                            t.part_id,
                            p.part_no
                        FROM 
                            tool t,
                            part p
                        WHERE 
                            t.part_id = p.id AND
                            t.deleted != 1 AND 
                            t.status = 1
                            $filter
                        GROUP by
                            t.part_id
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
                                tool t
                            WHERE
                                t.deleted != 1 AND 
                                t.status = 1 AND 
                                t.part_id = $partId
                        ";
                $stockQtyTotal = Yii::$app->db->createCommand($sqlQueryTotal)->queryOne();
                $stockQuery[$key]['sumsQ'] = number_format($stockQtyTotal['sumsQ'], 3, '.', '');
                $stockQuery[$key]['unit_id'] = $dataUnit[$stockQtyTotal['unit_id']];
            }


        /* get result data here */
            $dataProvider = new ArrayDataProvider([
                'key'=>'id',
                'pagination' => [
                    'pageSize' => 20,
                ],
                'allModels' => $stockQuery,
                'sort' => [
                    'attributes' => ['part_id'],
                ],
            ]); 


        return $this->render('tool', [
            'dataProvider' => $dataProvider,
            'stockQuery' => $stockQuery,
        ]);
    }


    /**
     * Preview Stock and its history
     * @param integer $id
     * @return mixed
     */
    public function actionPreviewTool($id)
    {   
        
        $model = $this->findModel($id);
        $partId = $model->part_id;
        $stockPart = Tool::find()->where(['part_id' => $model->part_id])->all();
        
            $searchModel = new SearchTool();
            $dataProvider = $searchModel->searchTool($partId, Yii::$app->request->queryParams);


        return $this->render('preview-tool', [
            'stockPart' => $stockPart,
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * CRON Job for Next Calibration Notification .
     * @return mixed
     */
    public function actionCronNextcalibration()
    {
        $toolCalibration = Tool::getNextCalibration();

        /* get email settings */
            $emailFrom = 'no-reply@firstcom.com.sg';
            $emailSettings = Setting::find()->where([ 'name' => 'email_calibration' ])->all();
            $emailTo = '';

        if ( count($toolCalibration) > 0 ) { 
            foreach ($emailSettings as $email){
                $emailTo .= $email->value;
            }
            /*get rental and then send email to notify the shops */
            Yii::$app->mailer->compose('layouts/calibration',[
            'toolCalibration' => $toolCalibration,
            ])
            ->setFrom($emailFrom)
            ->setTo($emailTo)
            ->setSubject('[Reminder] The following tools calibration is due soon!')
            ->send();
        }
    }
}
