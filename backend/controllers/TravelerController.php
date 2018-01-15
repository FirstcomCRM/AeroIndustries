<?php

namespace backend\controllers;

use Yii;
use common\models\Traveler;
use common\models\SearchTraveler;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\TravelerContent;
use common\models\TravelerSub;
use common\models\TravelerLog;
use yii\web\UploadedFile;

/**
 * TravelerController implements the CRUD actions for Traveler model.
 */
class TravelerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Traveler'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all Traveler models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchTraveler();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Traveler models.
     * @return mixed
     */
    public function actionOld()
    {
        $searchModel = new SearchTraveler();
        $dataProvider = $searchModel->searchOld(Yii::$app->request->queryParams);

        return $this->render('old', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


/**
* crud
*/    
        /**
         * Finds the Traveler model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return Traveler the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = Traveler::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }



/**
* custom
*/   
    /**
     * Creates a new Traveler .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew()
    {
        $model = new Traveler();
        $travelerLog = false;

        if ($model->load(Yii::$app->request->post()) ) {
            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;
                $travelerAttachment = UploadedFile::getInstances($model, 'attachment');
                foreach ( $travelerAttachment as $trA ) {
                    $fileName = md5(date("YmdHis")).'-'.$trA->name;
                    $qAttachmentClass = explode('\\', get_class($model))[2];
                    $trA->saveAs('uploads/traveler/'.$fileName);
                }
            $model->value = $fileName;

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        } 
        return $this->render('new', [
            'model' => $model,
            'travelerLog' => $travelerLog,
        ]);
        
    }

    /**
     * Edit an existing Traveler .
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        $travelerLog = new TravelerLog();
        $oldValue = $model->value;
        /* post */
        if ($model->load(Yii::$app->request->post()) ) {
            // dx(Yii::$app->request->post());
            // d(Yii::$app->request->post());exit;
            $model->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->updated = $currentDateTime;
                $travelerAttachment = UploadedFile::getInstances($model, 'attachment');
                if (!empty($travelerAttachment)) {
                    foreach ( $travelerAttachment as $trA ) {
                        $fileName = md5(date("YmdHis")).'-'.$trA->name;
                        $qAttachmentClass = explode('\\', get_class($model))[2];
                        $trA->saveAs('uploads/traveler/'.$fileName);
                    }
                    $model->value = $fileName;
                    unlink('uploads/traveler/'.$oldValue);

                    $travelerLog->load(Yii::$app->request->post());
                    $travelerLog->created_by = Yii::$app->user->identity->id;
                    $currentDateTime = date("Y-m-d H:i:s");
                    $travelerLog->created = $currentDateTime;
                    $travelerLog->traveler_id = $id;
                    $travelerLog->save();
                }

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        } 
        return $this->render('edit', [
            'model' => $model,
            'travelerLog' => $travelerLog,
        ]);
        
    }

    /**
     * Displays a single Traveler .
     * @param integer $id
     * @return mixed
     */
    public function actionPreview($id)
    {
        $model = $this->findModel($id);
        $log = TravelerLog::getTravelerLog($id);
        return $this->render('preview', [
            'log' => $log,
            'model' => $model,
        ]);
        // $value = $model->value;
        // return $this->redirect('uploads/traveler/'.$value);
    }
    /**
     * Displays a single Traveler .
     * @param integer $id
     * @return mixed
     */
    public function actionDownload($id)
    {
        $model = $this->findModel($id);
        $value = $model->value;
        return $this->redirect('uploads/traveler/'.$value);
    }


    /**
     * Deletes an existing Traveler model by changing the delete status to 1 .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRemove($id)
    {
        $model = $this->findModel($id);
        $model->status = 'deleted';
        $model->value = $fileName;
        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'Traveler deleted');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to delete Traveler');
        }

        return $this->redirect(['index']);
    }
    /**
     * Displays a single Traveler .
     * @param integer $id
     * @return mixed
     */
    public function actionPrint($id)
    {
        $this->layout = 'print';
        return $this->render('print', [
            'model' => $this->findModel($id),
        ]);
    }




/**
* AJAX FUNCTION.
*/
    public function actionAjaxContent()
    {   
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $postData = Yii::$app->request->post();
            $content = $postData['content'];
            $data['content'] = $content;
            return json_encode($data);
        }
    }
    public function actionAjaxAddlink()
    {   
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $postData = Yii::$app->request->post();
            $nn = $postData['nn'];

            return $this->render('ajax-addlink', [
                'nn' => $nn,
            ]);
        }
    }
    public function actionAjaxAddsublink()
    {   
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $postData = Yii::$app->request->post();
            $nn = $postData['nn'];
            $nnn = $postData['nnn'];

            return $this->render('ajax-addsublink', [
                'nn' => $nn,
                'nnn' => $nnn,
            ]);
        }
    }
    public function actionAjaxAddtextfield()
    {   
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $postData = Yii::$app->request->post();
            $nn = $postData['nn'];
            $nnn = $postData['nnn'];

            return $this->render('ajax-addtextfield', [
                'nn' => $nn,
                'nnn' => $nnn,
            ]);
        }
    }
    public function actionAjaxAddcheckbox()
    {   
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $postData = Yii::$app->request->post();
            $nn = $postData['nn'];
            $nnn = $postData['nnn'];

            return $this->render('ajax-addcheckbox', [
                'nn' => $nn,
                'nnn' => $nnn,
            ]);
        }
    }



}
