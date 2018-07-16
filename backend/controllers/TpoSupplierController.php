<?php

namespace backend\controllers;

use Yii;
use common\models\TpoSupplier;
use common\models\SearchTpoSupplier;
use common\models\TpoSupplierAttachment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;

/**
 * TpoSupplierController implements the CRUD actions for TpoSupplier model.
 */
class TpoSupplierController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');

        foreach ( $userGroupArray as $uGId => $uGName ){
            $permission = UserPermission::find()->where(['controller' => 'TpoSupplier'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all TpoSupplier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchTpoSupplier();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TpoSupplier model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
          $oldSA = TpoSupplierAttachment::find()->where(['supplier_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'oldSA' => $oldSA,
        ]);
    }

    /**
     * Creates a new TpoSupplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TpoSupplier();
        $oldSA = false;
        $supplierAttachment = new TpoSupplierAttachment();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->created_by = Yii::$app->user->identity->id;
            $model->created = date("Y-m-d H:i:s");
            if ($model->save()) {
                $supplierId = $model->id;
              //  return $this->redirect(['view', 'id' => $model->id]);
            }
            if ( $supplierAttachment->load(Yii::$app->request->post()) ) {
                $supplierAttachment->attachment = UploadedFile::getInstances($supplierAttachment, 'attachment');
                foreach ($supplierAttachment->attachment as $file) {
                    $fileName = $file->name;
                    $supplierAttachmentClass = explode('\\', get_class($supplierAttachment))[2];
                    $file->saveAs('uploads/'.$supplierAttachmentClass.'/'.$fileName);
                    /* image upload */

                    $sA = new TpoSupplierAttachment();
                    $sA->supplier_id = $supplierId;
                    $sA->value = $fileName;
                    $sA->save();

                }

            }
            Yii::$app->getSession()->setFlash('success', 'GPO Supplier Created!');
            return $this->redirect(['view', 'id' => $model->id]);

        }
        return $this->render('create', [
            'model' => $model,
            'supplierAttachment' => $supplierAttachment,
            'oldSA' => $oldSA,
        ]);

    }

    /**
     * Updates an existing TpoSupplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldSA = TpoSupplierAttachment::find()->where(['supplier_id' => $id])->all();
        $supplierAttachment = new TpoSupplierAttachment();

        if ($model->load(Yii::$app->request->post()) ) {

            if ($model->save()) {
              if ( $supplierAttachment->load(Yii::$app->request->post()) ) {
                  $supplierAttachment->attachment = UploadedFile::getInstances($supplierAttachment, 'attachment');
                  foreach ($supplierAttachment->attachment as $file) {
                      $fileName = $file->name;
                      $supplierAttachmentClass = explode('\\', get_class($supplierAttachment))[2];
                      $file->saveAs('uploads/'.$supplierAttachmentClass.'/'.$fileName);
                      /* image upload */

                      $sA = new TpoSupplierAttachment();
                      $sA->supplier_id = $id;
                      $sA->value = $fileName;
                      $sA->save();

                  }
                  Yii::$app->getSession()->setFlash('success', 'GPO Supplier Updated!');
                  return $this->redirect(['view', 'id' => $model->id]);
              }
                //return $this->redirect(['view', 'id' => $model->id]);
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
     * Deletes an existing TpoSupplier model.
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
     * Finds the TpoSupplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TpoSupplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TpoSupplier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    /**
     * Creates a new TpoSupplier .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew()
    {
        $model = new TpoSupplier();

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
     * Edit an existing TpoSupplier .
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
     * Displays a single TpoSupplier .
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
     * Deletes an existing TpoSupplier model by changing the delete status to 1 .
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
