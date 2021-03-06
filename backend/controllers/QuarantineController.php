<?php

namespace backend\controllers;

use Yii;
use common\models\Quarantine;
use common\models\SearchQuarantine;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\WorkOrderPart;
use common\models\UphosteryPart;

/**
 * QuarantineController implements the CRUD actions for Quarantine model.
 */
class QuarantineController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');

        foreach ( $userGroupArray as $uGId => $uGName ){
            $permission = UserPermission::find()->where(['controller' => 'Quarantine'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all Quarantine models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchQuarantine();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Finds the Quarantine model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quarantine the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quarantine::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    /**
     * Creates a new Quarantine .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew($work_order_part_id)
    {

        $model = new Quarantine();
        $part = WorkOrderPart::find()->where(['id'=>$work_order_part_id])->one();
        $model->work_order_id = $part->work_order_id;
        $model->work_order_part_id = $work_order_part_id;
        $model->part_no = $part->part_no;
        $model->desc = $part->desc;
        $model->quantity = $part->quantity;
        $model->serial_no = $part->serial_no;
        $model->work_type = 'work_order';
        $model->batch_no = $part->batch_no;
        $model->created = date('Y-m-d H:i:s');
        $model->created_by = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) ) {
            $part->status='quarantined';
            $part->save(false);
            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;


            if ($model->save()) {
                return $this->redirect(['preview', 'id' => $model->id]);
            }
        }
        return $this->render('new', [
            'model' => $model,
        ]);

    }

    public function actionNewUp($uphostery_part_id)
    {

        $model = new Quarantine();
        $part = UphosteryPart::find()->where(['id'=>$uphostery_part_id])->one();
        $model->work_order_id = $part->uphostery_id;
        $model->work_order_part_id = $uphostery_part_id;
        $model->part_no = $part->part_no;
        $model->desc = $part->desc;
        $model->work_type = 'upholstery';
        $model->quantity = $part->quantity;
        $model->serial_no = $part->serial_no;
        $model->batch_no = $part->batch_no;
        $model->created = date('Y-m-d H:i:s');
        $model->created_by = Yii::$app->user->id;
      // echo '<pre>';
      //  print_r($model);
      //  echo '</pre>';
        //die();
        if ($model->load(Yii::$app->request->post()) ) {
            $part->status='quarantined';
            $part->save(false);
            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;


            if ($model->save()) {
                return $this->redirect(['preview', 'id' => $model->id]);
            }
        }
        return $this->render('new-up', [
            'model' => $model,
        ]);

    }




    /**
     * Edit an existing Quarantine .
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
     * Displays a single Quarantine .
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
     * Deletes an existing Quarantine model by changing the delete status to 1 .
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
}
