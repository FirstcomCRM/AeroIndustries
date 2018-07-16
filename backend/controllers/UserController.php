<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\SearchUser;
use common\models\Staffs;
use common\models\Customers;
use common\models\UploadForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;

use yii\imagine\Image;
/**
 * UserController implements the CRUD actions for User model.
 */

class UserController extends Controller
{
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'User'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new User();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $auth = Yii::$app->authManager;

        if ($model->load(Yii::$app->request->post()) ) {
            if ( !empty ( $model->password ) ) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
                $model->generateAuthKey();
                unset($model->password);
            }

            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = new \yii\db\Expression('NOW()');
            $model->created_at = $currentDateTime;
            if ( $model->save() ) { 
                $userGroupId = $model->user_group_id;

                if ( $userGroupId == 1) {
                    $userGroup = $auth->getRole('admin');
                    $auth->assign($userGroup, $model->id);
                }
                if ( $userGroupId == 2) {
                    $userGroup = $auth->getRole('engineer');
                    $auth->assign($userGroup, $model->id);
                }
                if ( $userGroupId == 3) {
                    $userGroup = $auth->getRole('mechanic');
                    $auth->assign($userGroup, $model->id);
                }
                if ( $userGroupId == 4) {
                    $userGroup = $auth->getRole('purchasing');
                    $auth->assign($userGroup, $model->id);
                }
                if ( $userGroupId == 5) {
                    $userGroup = $auth->getRole('quality');
                    $auth->assign($userGroup, $model->id);
                }
                            
                return $this->redirect(['index']);
            } else {
                if( $model->getErrors()['username'] ){
                    Yii::$app->getSession()->setFlash('warning', $model->getErrors()['username'][0]);
                } else if ( $model->getErrors()['email'] ) {
                    Yii::$app->getSession()->setFlash('warning', $model->getErrors()['email'][0]);
                }
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            if ( !empty ( $model->password ) ) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
                $model->generateAuthKey();
                unset($model->password);
            }

            $model->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = new \yii\db\Expression('NOW()');
            $model->updated_at = $currentDateTime;

            if ( $model->save() ) { 
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Change password.
     * @param integer $id
     * @return mixed
     */
    public function actisonChangePassword()
    {

        $userId = Yii::$app->user->identity->id;
        $user = User::find()->where( ['id' => $userId] )->one(); 

        if ( $user->load(Yii::$app->request->post()) ) {

            if ( !empty ( $user->password ) ) {

                $user->password_hash = Yii::$app->security->generatePasswordHash($user->password); 
                $user->generateAuthKey();
                unset($user->password);
                unset($user['confirm_password']);


                if ( $user->save() ) {
                    Yii::$app->getSession()->setFlash('success', 'Password changed!');
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Password change failed!');
                }

            }

        }


        return $this->render('change-password', [
            'user' => $user,
        ]);

    }

    /**
     * View personal profile after login
     * @param integer $id
     * @return mixed
     */
    public function actiosnMyProfile()
    {

        $userId = Yii::$app->user->identity->id;
        $user = User::find()->where( ['id' => $userId] )->one();
        $userGroup = $user->user_group_id;
        $staff = false; $customer = false;
        $model = false;
        if ( $userGroup == 3 ) {
            $model = Staffs::find()->where( ['user_id' => $userId] )->one(); 
        } 
        if ( $userGroup == 4 ) { 
            $model = Customers::find()->where( ['user_id' => $userId] )->one(); 
        }

        return $this->render('my-profile', [
            'user' => $user,
            'model' => $model,
            'userGroup' => $userGroup,
        ]);

    }

    /**
     * Update profile for staff
     * @param integer $id
     * @return mixed
     */
    public function actisonUpdateProfile()
    {   
        $upload = new UploadForm();
        $id = Yii::$app->user->identity->id;
        $user = User::findOne($id);
        $userGroup = $user->user_group_id;
        $isStaff = false;
        $staff = Staffs::findOne([
            'user_id' => $id,
        ]);

        if ( $user->load(Yii::$app->request->post()) ) {
            if ( !empty ( $user->password ) ) {
                $user->password_hash = Yii::$app->security->generatePasswordHash($user->password); 
                $user->generateAuthKey();
                unset($user->password);
            }


            if ( UploadedFile::getInstance($user, 'file') ) {
                

                $user->file = UploadedFile::getInstance($user, 'file');
                $getFileName = explode('.', $user->file->name);
                $user->file->name = hash('sha256', $getFileName[0] . strval(time())).'.'.$getFileName[1];
                $user->file->saveAs('uploads/user/'.$user->file->name);
                Image::thumbnail('@webroot/uploads/user/'.$user->file->name, 120, 120)
                ->save(Yii::getAlias('@webroot/uploads/user/thumbs/'.$user->file->name), ['quality' => 80]);
                $attachmentName = $user->file->name;
                $user->photo = $attachmentName;
            }

            
            $user->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = new \yii\db\Expression('NOW()');
            $user->updated_at = $currentDateTime;
            $user->save();

              
            if ( $staff->load(Yii::$app->request->post()) ){
                
                /* image upload */
                $staff->file = UploadedFile::getInstance($staff, 'file');

                if ( !empty ( $staff->file ) ) {

                    $getFileName = explode('.', $staff->file->name);
                    $staff->file->name = hash('sha256', $getFileName[0] . strval(time())).'.'.$getFileName[1];
                    $staff->file->saveAs('uploads/staffs/'.$staff->file->name);
                    $attachmentName = $staff->file->name;
                    $staff->attachment = $attachmentName;

                }
                /* image upload */

                $staff->email = $user->email;

                $staff->updated_by = Yii::$app->user->identity->id;
                $currentDateTime = new \yii\db\Expression('NOW()');
                $staff->updated = $currentDateTime;

                $staff->save();
                
            }


            
        } else {  /* if else is post - user */ 

            return $this->render('update-profile', [
                'user' => $user,
                'staff' => $staff,
                'isStaff' => $isStaff,
            ]);
        }
        
        return $this->redirect(['user/my-profile']);

    }


    /**
     * Update profile for staff
     * @param integer $id
     * @return mixed
     */
    public function actiosnEditProfile()
    {   
        $upload = new UploadForm();
        $id = Yii::$app->user->identity->id;
        $user = User::findOne($id);
        $userGroup = $user->user_group_id;
        $isCustomer = false;
        $customer = Customers::findOne([
            'user_id' => $id,
        ]);

        if ( $user->load(Yii::$app->request->post()) ) {
            if ( !empty ( $user->password ) ) {
                $user->password_hash = Yii::$app->security->generatePasswordHash($user->password); 
                $user->generateAuthKey();
                unset($user->password);
            }


            if ( UploadedFile::getInstance($user, 'file') ) {
                $user->file = UploadedFile::getInstance($user, 'file');
                $getFileName = explode('.', $user->file->name);
                $user->file->name = hash('sha256', $getFileName[0] . strval(time())).'.'.$getFileName[1];
                $user->file->saveAs('uploads/user/'.$user->file->name);
                Image::thumbnail('@webroot/uploads/user/'.$user->file->name, 120, 120)
                ->save(Yii::getAlias('@webroot/uploads/user/thumbs/'.$user->file->name), ['quality' => 80]);
               
                /* image upload */
                $attachmentName = $user->file->name;
                $user->photo = $attachmentName;
            }

            
            $user->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = new \yii\db\Expression('NOW()');
            $user->updated_at = $currentDateTime;
            $user->save();

              
            if ( $customer->load(Yii::$app->request->post()) ){
                
                /* image upload */
                $customer->file = UploadedFile::getInstance($customer, 'file');

                if ( !empty ( $customer->file ) ) {
                    $attachmentName = $customer->file->name;
                    $customer->file->saveAs('uploads/customers/'.$customer->file->name);
                    $attachmentName = $customer->file->name;
                    $customer->attachment = $attachmentName;
                }
                /* image upload */

                $customer->email = $user->email;

                $customer->modified_by = Yii::$app->user->identity->id;
                $currentDateTime = new \yii\db\Expression('NOW()');
                $customer->modified = $currentDateTime;

                $customer->save();
                
            }


            
        } else {  /* if else is post - user */ 

            return $this->render('edit-profile', [
                'user' => $user,
                'customer' => $customer,
                'isCustomer' => $isCustomer,
            ]);
        }
        
        return $this->redirect(['user/my-profile']);

    }


}
