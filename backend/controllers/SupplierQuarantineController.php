<?php

namespace backend\controllers;

use Yii;
use common\models\SupplierQuarantine;
use common\models\SearchSupplierQuarantine;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\Stock;

/**
 * SupplierQuarantineController implements the CRUD actions for SupplierQuarantine model.
 */
class SupplierQuarantineController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'SupplierQuarantine'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all SupplierQuarantine models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchSupplierQuarantine();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the SupplierQuarantine model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SupplierQuarantine the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SupplierQuarantine::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    /**
     * Creates a new SupplierQuarantine .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew($s_id,$qty)
    {
        $model = new SupplierQuarantine();

        if ($model->load(Yii::$app->request->post()) ) {
            $postData = Yii::$app->request->post();
            $id = $s_id;
            $stock = Stock::getStock($id);
            $quantityDeduct = $model->quantity;
            $stock->quantity = $stock->quantity - $quantityDeduct;
            $stock->save();
            
            $model->created_by = Yii::$app->user->identity->id;
            $model->created = date("Y-m-d H:i:s");
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Quarantine updated!');
                return $this->redirect(['index']);
            }
        } 
        return $this->render('new', [
            'model' => $model,
        ]);
        
    }

    /**
     * Edit an existing SupplierQuarantine .
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated = date("Y-m-d H:i:s");
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Quarantine updated!');
                return $this->redirect(['index']);
            }
        } 
        return $this->render('edit', [
            'model' => $model,
        ]);
        
    }

    /**
     * Displays a single SupplierQuarantine .
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
     * Deletes an existing SupplierQuarantine model by changing the delete status to 1 .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRemove($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'Quarantine deleted');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to delete Quarantine');
        }

        return $this->redirect(['index']);
    }
}
