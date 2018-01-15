<?php

namespace backend\controllers;

use Yii;
use common\models\Rfq;
use common\models\SearchRfq;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

use common\models\RfqAttachment;
use common\models\UserGroup;
use common\models\UserPermission;

/**
 * RfqController implements the CRUD actions for Rfq model.
 */
class RfqController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Rfq'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all Rfq models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchRfq();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rfq model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   

        return $this->render('view', [
            'model' => $this->findModel($id),
            'atta' => RfqAttachment::getRfqAttachment($id),
        ]);
    }

    /**
     * Creates a new Rfq model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rfq();
        $atta = new RfqAttachment();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;

            if ($model->save()) {
                $rfqId = $model->id;
                if ($atta->load(Yii::$app->request->post()) ) {
                    $atta->attachment = UploadedFile::getInstances($atta, 'attachment');
                    foreach ($atta->attachment as $file) {
                        $fileName = md5(date("YmdHis")).'-'.$file->name;
                        $qAttachmentClass = explode('\\', get_class($atta))[2];
                        $file->saveAs('uploads/rfq/'.$fileName);
                        /* image upload */
                        $rfqA = new RfqAttachment();
                        $rfqA->rfq_id = $rfqId;
                        $rfqA->value = $fileName;
                        $rfqA->save();

                    }
                }
                return $this->redirect(['view', 'id' => $rfqId]);
            }
        } 
        return $this->render('create', [
            'model' => $model,
            'atta' => $atta,
        ]);
    }

    /**
     * Updates an existing Rfq model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $atta = new RfqAttachment();
        $currAtta = RfqAttachment::getRfqAttachment($id);

        if ($model->load(Yii::$app->request->post()) ) {

                $model->updated_by = Yii::$app->user->identity->id;
                $currentDateTime = date("Y-m-d H:i:s");
                $model->updated = $currentDateTime;

            if ($model->save()) {
                $rfqId = $model->id;
                if ($atta->load(Yii::$app->request->post()) ) {
                    $atta->attachment = UploadedFile::getInstances($atta, 'attachment');
                    foreach ($atta->attachment as $file) {
                        $fileName = md5(date("YmdHis")).'-'.$file->name;
                        $qAttachmentClass = explode('\\', get_class($atta))[2];
                        $file->saveAs('uploads/rfq/'.$fileName);
                        /* image upload */
                        $rfqA = new RfqAttachment();
                        $rfqA->rfq_id = $rfqId;
                        $rfqA->value = $fileName;
                        $rfqA->save();

                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } 
        return $this->render('update', [
            'model' => $model,
            'atta' => $atta,
            'currAtta' => $currAtta,
        ]);
        
    }
    /**
     * Finds the Rfq model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rfq the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rfq::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Deletes an existing Rfq model by changing the delete status to 1 .
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
     * remove rfq attachment
     * @param integer $id = rfq atta id 
     * @return mixed
     */
    public function actionRemoveAtta($id)
    {
        $att = RfqAttachment::find()->where( ['id' => $id] )->one();
        $value = $att->value;
            /* remove file */
            $fileName = "uploads/rfq/$value";
            unlink($fileName);

        if ( $att->delete() ) {
            Yii::$app->getSession()->setFlash('success', 'Attachment removed!');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to remove the attachment!');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

}
