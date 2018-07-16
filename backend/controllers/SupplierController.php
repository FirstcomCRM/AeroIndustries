<?php

namespace backend\controllers;

use Yii;
use common\models\SupplierAttachment;
use common\models\Supplier;
use common\models\SearchSupplier;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;

/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends Controller
{
    /**
     * @inheritdoc
     */
    
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Supplier'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all Supplier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchSupplier();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Supplier model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $oldSA = SupplierAttachment::find()->where(['supplier_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'oldSA' => $oldSA,
        ]);
    }

    /**
     * Creates a new Supplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
        $oldSA = false;
        $model = new Supplier();
        $supplierAttachment = new SupplierAttachment();
        if ( $model->load(Yii::$app->request->post()) ) {
// d( Yii::$app->request->post()) ;
            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;
            if( $model->save()) {
                $supplierId = $model->id;
                // return $this->redirect(['supplier-attachment/create', 'id' => $model->id]);
            }
            if ( $supplierAttachment->load(Yii::$app->request->post()) ) {
                $supplierAttachment->attachment = UploadedFile::getInstances($supplierAttachment, 'attachment');
                foreach ($supplierAttachment->attachment as $file) {
                    $fileName = $file->name;
                    $supplierAttachmentClass = explode('\\', get_class($supplierAttachment))[2];
                    $file->saveAs('uploads/'.$supplierAttachmentClass.'/'.$fileName);
                    /* image upload */

                    $sA = new SupplierAttachment();
                    $sA->supplier_id = $supplierId;
                    $sA->value = $fileName;
                    $sA->save();

                }
                    
            }

            Yii::$app->getSession()->setFlash('success', 'Supplier Created!');    
            return $this->redirect(['supplier/view', 'id' => $supplierId]); 



        } 

        return $this->render('create', [
            'model' => $model,
            'supplierAttachment' => $supplierAttachment,
            'oldSA' => $oldSA,
        ]);
       
    }

    /**
     * Updates an existing Supplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldSA = SupplierAttachment::find()->where(['supplier_id' => $id])->all();
        $supplierAttachment = new SupplierAttachment();

        if ($model->load(Yii::$app->request->post()) ) {

            if ( $model->save() ) {
                if ( $supplierAttachment->load(Yii::$app->request->post()) ) {
                    $supplierAttachment->attachment = UploadedFile::getInstances($supplierAttachment, 'attachment');
                    foreach ($supplierAttachment->attachment as $file) {
                        $fileName = $file->name;
                        $supplierAttachmentClass = explode('\\', get_class($supplierAttachment))[2];
                        $file->saveAs('uploads/'.$supplierAttachmentClass.'/'.$fileName);
                        /* image upload */

                        $sA = new SupplierAttachment();
                        $sA->supplier_id = $id;
                        $sA->value = $fileName;
                        $sA->save();

                    }
                        
                }

                Yii::$app->getSession()->setFlash('success', 'Supplier Updated!');    
                return $this->redirect(['supplier/view', 'id' => $id]); 
            }
            Yii::$app->getSession()->setFlash('danger', 'Unable to save!');    
       }
        return $this->render('update', [
            'model' => $model,
            'supplierAttachment' => $supplierAttachment,
            'oldSA' => $oldSA,
        ]);
    }

    /**
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Deletes an existing StorageLocation model by changing the delete status to 1
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteColumn($id)
    {
        // $this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->deleted = 1;
        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'Supplier deleted');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to delete Supplier');
        }

        return $this->redirect(['index']);
    }
}
