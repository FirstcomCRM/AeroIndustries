<?php

namespace backend\controllers;

use Yii;
use common\models\SearchUserPermission;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;

/**
 * UserPermissionController implements the CRUD actions for UserPermission model.
 */
class UserPermissionController extends Controller
{
    /**
     * @inheritdoc
     */
    
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'UserPermission'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all UserPermission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUserPermission();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserPermission model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserPermission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserPermission();

        if ($model->load(Yii::$app->request->post()) ) {

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        } 
        return $this->render('create', [
            'model' => $model,
        ]);
        
    }

    /**
     * Updates an existing UserPermission model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        } 
        return $this->render('update', [
            'model' => $model,
        ]);
        
    }

    /**
     * Deletes an existing UserPermission model.
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
     * Finds the UserPermission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserPermission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserPermission::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    /**
     * Creates a new UserPermission .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew()
    {
        $model = new UserPermission();

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
     * Edit an existing UserPermission .
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
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
     * Displays a single UserPermission .
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
     * Deletes an existing UserPermission model by changing the delete status to 1 .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRemove($id)
    {
        $model = $this->findModel($id);
        $model->deleted = 1;
        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'Customer deleted');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to delete Customer');
        }

        return $this->redirect(['index']);
    }

    public function actionPermissionSetting()
    {   
        /* get all controller */
        $controllerlist = [];
        if ($handle = opendir('../controllers')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                    $controllerlist[] = $file;
                }
            }
            closedir($handle);
        }
        asort($controllerlist);
        
        $controllerList = [];
        foreach ($controllerlist as $controller):
            if ( $controller != 'UserPermissionController.php' && $controller != 'UserGroupController.php' ) {
                $handle = fopen('../controllers/' . $controller, "r");
                if ($handle) {
                    while (($line = fgets($handle)) !== false) {
                        if (preg_match('/public function action(.*?)\(/', $line, $display)):
                            if (strlen($display[1]) > 2):
                                $addDash = preg_replace('/\B([A-Z])/', '-$1', $display[1]);
                                $controllerList[substr($controller, 0, -4)][] = strtolower($addDash);
                                // d($addDash);
                            endif;
                        endif;
                    }
                }
                fclose($handle);
            }
        endforeach;
        $controllerActions = false;
        $userGroupId = 0;
        $controllerNameChosen = '';
        $controllerNameLong = '';
        $userGroup = UserGroup::find()->all();
        $permission = [];


        if ( isset( $_GET['c'] ) && !empty( $_GET['c'] ) && isset( $_GET['u'] ) && !empty( $_GET['u'] ) ) {
            $controllerName = $_GET['c'];
            $userGroupId = $_GET['u'];

            $controllerNameLong = $controllerName.'Controller';
            $controllerNameChosen = $controllerNameLong;
            $controllerActions = $controllerList[$controllerNameLong];
           
            $getPermission = UserPermission::find()->where(['user_group_id' => $userGroupId])->andWhere(['controller' => $controllerName])->all();
            foreach ( $getPermission as $gP ) {
                $permission[] = $gP->action;
            }
        }

        if (Yii::$app->request->post()) {
            // d(Yii::$app->request->post());exit;
            $controllerNameLong = Yii::$app->request->post()['controllerName'];
            $getModelName = explode('Controller', $controllerNameLong);
            $controllerName = $getModelName[0];
            $userGroupId = Yii::$app->request->post()['userGroup'];

            $controllerNameChosen = $controllerNameLong;
            $controllerActions = $controllerList[$controllerNameLong];
            $permission = [];
            $getPermission = UserPermission::find()->where(['user_group_id' => $userGroupId])->andWhere(['controller' => $controllerName])->all();
            foreach ( $getPermission as $gP ) {
                $permission[] = $gP->action;
            }


            if ( isset( Yii::$app->request->post()['checkBox'] ) && !empty ( Yii::$app->request->post()['checkBox'] ) )  {
            // d(Yii::$app->request->post());exit;
                UserPermission::deleteAll("user_group_id = $userGroupId AND controller = '$controllerName' ");
                $checkBox = Yii::$app->request->post()['checkBox'] ;
                foreach ( $checkBox as $actions => $cB ) {
                    $newPermission = new UserPermission();
                    $newPermission->controller = $controllerName;
                    $newPermission->action = $actions;
                    $newPermission->user_group_id = $userGroupId;
                    $newPermission->save();
                }
                return $this->redirect(['permission-setting','c' => $controllerName, 'u' => $userGroupId]);
            }
        }

        return $this->render('permission-setting', [
            'userGroup' => $userGroup,
            'userGroupId' => $userGroupId,
            // 'getModelName' => $getModelName,
            'controllerNameLong' => $controllerNameLong,
            'controllerNameChosen' => $controllerNameChosen,
            'controllerList' => $controllerList,
            'controllerActions' => $controllerActions,
            'permission' => $permission,
        ]);
    }   
}
