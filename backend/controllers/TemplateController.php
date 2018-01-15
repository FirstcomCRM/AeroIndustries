<?php

namespace backend\controllers;

use Yii;
use common\models\Template;
use common\models\SearchTemplate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\TemplateAlt;

/**
 * TemplateController implements the CRUD actions for Template model.
 */
class TemplateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Template'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all Template models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchTemplate();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

/* crud */
 

    /**
     * Finds the Template model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Template the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Template::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


/* custom */
    /**
     * Creates a new Template .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew()
    {
        $model = new Template();
        $alt = new TemplateAlt();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;

            if ($model->save()) {
                $templateId = $model->id;
                // if ($alt->load(Yii::$app->request->post()) ) {

                //     foreach ( $alt->part_no as $pN ) {
                //         if ( !empty ( $pN ) ) {
                //             $eachAlt = new TemplateAlt();
                //             $eachAlt->template_id = $templateId;
                //             $eachAlt->part_no = $pN;
                //             $eachAlt->created_by = Yii::$app->user->identity->id;
                //             $currentDateTime = date("Y-m-d H:i:s");
                //             $eachAlt->created = $currentDateTime;
                //             $eachAlt->save();
                //         }
                //     }

                // }

                    Yii::$app->getSession()->setFlash('success', 'Template created');
                    return $this->redirect(['index']);
            }
        } 
        return $this->render('new', [
            'model' => $model,
            'alt' => $alt,
        ]);
        
    }

    /**
     * Edit an existing Template .
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        $alt = new TemplateAlt();
        $altEx = TemplateAlt::find()->where(['template_id' => $id])->all();

        if ($model->load(Yii::$app->request->post()) ) {
            // d( Yii::$app->request->post() ) ;exit;
            $model->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->updated = $currentDateTime;

            if ($model->save()) {
                $templateId = $model->id;
                // if ($alt->load(Yii::$app->request->post()) ) {

                //     /* delete all the related alt and insert again */
                //     TemplateAlt::deleteAll("template_id = $id");

                //     foreach ( $alt->part_no as $pN ) {
                //         if ( !empty ( $pN ) ) {
                //             $eachAlt = new TemplateAlt();
                //             $eachAlt->template_id = $templateId;
                //             $eachAlt->part_no = $pN;
                //             $eachAlt->created_by = Yii::$app->user->identity->id;
                //             $currentDateTime = date("Y-m-d H:i:s");
                //             $eachAlt->created = $currentDateTime;
                //             $eachAlt->save();
                //         }
                //     }

                // }

                    Yii::$app->getSession()->setFlash('success', 'Template updated');
                    return $this->redirect(['index']);
            }
        } 
        return $this->render('edit', [
            'model' => $model,
            'alt' => $alt,
            'altEx' => $altEx,
        ]);
        
    }

    /**
     * Displays a single Template .
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
     * Deletes an existing Template model by changing the delete status to 1 .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRemove($id)
    {
        $model = $this->findModel($id);
        $model->deleted = 1;
        if ( $model->save() ) {
            Yii::$app->getSession()->setFlash('success', 'Template deleted');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to delete Template');
        }

        return $this->redirect(['index']);
    }
}
