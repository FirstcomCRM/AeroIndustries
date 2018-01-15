<?php

namespace backend\controllers;

use Yii;
use common\models\Scrap;
use common\models\SearchScrap;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\WorkOrderPart;

/**
 * ScrapController implements the CRUD actions for Scrap model.
 */
class ScrapController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');

        foreach ( $userGroupArray as $uGId => $uGName ){
            $permission = UserPermission::find()->where(['controller' => 'Scrap'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all Scrap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchScrap();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Finds the Scrap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Scrap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Scrap::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Creates a new Scrap .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew($work_order_part_id)
    {
        $model = new Scrap();
        $part = WorkOrderPart::find()->where(['id'=>$work_order_part_id])->one();
        $model->work_order_id = $part->work_order_id;
        $model->work_order_part_id = $work_order_part_id;
        $model->part_no = $part->part_no;
        $model->description = $part->desc;
        $model->serial_no = $part->serial_no;
        $model->batch_no = $part->batch_no;
        $model->created = date('Y-m-d H:i:s');
        $model->created_by = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) ) {
            $part->status='scrapped';
            $part->save(false);
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('new', [
            'model' => $model,
            'part'=>$part
        ]);

    }

    /**
     * Deletes an existing Scrap model by changing the delete status to 1 .
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



    /**
     * Disposition Report
     * @param integer $id
     * @return mixed
     */
    public function actionDispositionReport($id)
    {
        $this->layout = 'print';
        return $this->render('disposition-report', [
            'model' => $this->findModel($id),
        ]);
    }

}
