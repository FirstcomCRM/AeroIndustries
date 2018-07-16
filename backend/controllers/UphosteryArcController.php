<?php

namespace backend\controllers;

use Yii;
use common\models\UphosteryArc;
use common\models\SearchUphosteryArc;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\Uphostery;
use common\models\UphosteryStaff;
use common\models\UphosteryPart;


/**
 * UphosteryArcController implements the CRUD actions for UphosteryArc model.
 */
class UphosteryArcController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'UphosteryArc'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all UphosteryArc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUphosteryArc();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
/**
 * CRUD
*/
        /**
         * Displays a single UphosteryArc model.
         * @param integer $id
         * @return mixed
         */
        public function actsionView($id)
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }

        /**
         * Creates a new UphosteryArc model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actsionCreate()
        {
            $model = new UphosteryArc();

            if ($model->load(Yii::$app->request->post()) ) {

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } 
            return $this->render('create', [
                'model' => $model,
            ]);
            
        }

        /**
         * Updates an existing UphosteryArc model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actisonUpdate($id)
        {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) ) {

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } 
            return $this->render('update', [
                'model' => $model,
            ]);
            
        }

        /**
         * Deletes an existing UphosteryArc model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actisonDelete($id)
        {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }

        /**
         * Finds the UphosteryArc model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return UphosteryArc the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = UphosteryArc::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }


/**
 * CUSTOM
*/
    /**
     * Creates a new UphosteryArc .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actisonNew()
    {
        $model = new UphosteryArc();

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
     * Edit an existing UphosteryArc .
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actisonEdit($id)
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
     * Displays a single UphosteryArc .
     * @param integer $id
     * @return mixed
     */
    public function actisonPreview($id)
    {
        return $this->render('preview', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Deletes an existing UphosteryArc model by changing the delete status to 1 .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actisonRemove($id)
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
     * Generate ARC .
     * @param integer $id = uphostery id 
     * @return mixed
     */
    public function actionGenerate($id,$uphostery_part_id)
    {   
        $subTitle = 'Generate ARC';
        $uphosteryId = $id;
        $model = new UphosteryArc();
        $uphostery = Uphostery::find()->where(['id' => $id])->one();
        $typeArr = [ 'EASA' => 'EASA', 'FAA' => 'FAA', 'CAAS' => 'CAAS', 'COC' => 'COC', 'CAAV' => 'CAAV', 'DCAM' => 'DCAM'];
        $dataType = [];
        foreach ( $typeArr as $key => $name ) {
            // $checkExistance = UphosteryArc::find()->where(['type' => $key])->andWhere(['uphostery_id' => $id])->exists();
            // if ( ! $checkExistance ) {
                $dataType[$key] = $key;
            // }
        }
        if ($model->load(Yii::$app->request->post()) ) {
            $type = $model->type; 
            $reprint = 0;
            $isGenerated = UphosteryArc::find()->where(['uphostery_id' => $uphosteryId, 'uphostery_part_id' => $uphostery_part_id, 'type' => $type])->exists();
            if ( $isGenerated ){
                $existedARC = UphosteryArc::find()->where(['uphostery_id' => $uphosteryId, 'uphostery_part_id' => $uphostery_part_id, 'type' => $type])->one();
                $reprint = $existedARC->reprint;
            }
            UphosteryArc::deleteAll(['uphostery_id' => $uphosteryId, 'uphostery_part_id' => $uphostery_part_id, 'type' => $type]);
            if ( $type == 'CAAS') {
                $formTrackNo = 1;
                $fTN = UphosteryArc::find()->where(['type' => $key])->orderBy('form_tracking_no DESC')->limit(1)->one();
                if ( !empty ( $fTN ) ) {
                    $previousNo = $fTN->form_tracking_no;
                    $formTrackNo = $previousNo+1;
                }
                $model->form_tracking_no = $formTrackNo;
            } 
            $model->uphostery_id = $uphosteryId;
            $model->uphostery_part_id = $uphostery_part_id;
            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;
            if ( $isGenerated ) {
                if ($model->is_tracking_no){
                    $model->reprint = $reprint + 1;
                }
            }    
            if ( $model->save() ) {
                Yii::$app->getSession()->setFlash('success', "ARC for $type generated");
                return $this->redirect(['uphostery/preview', 'id' => $uphosteryId, 'uphostery_part_id' => $uphostery_part_id]);
            }
        } 
        return $this->render('generate', [
            'model' => $model,
            'subTitle' => $subTitle,
            'dataType' => $dataType,
        ]);
    }
    /**
     * print CAA
     * @param integer $id
     * @return mixed
     */
    public function actionPrintCaa($id,$uphostery_part_id)
    {   
        $this->layout = 'print-arc';
        $model = Uphostery::find()->where(['id' => $id])->one();
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $arc = UphosteryArc::find()->where(['type' => 'CAAS'])->andWhere(['uphostery_id' => $id])->one();
        $inspector = UphosteryStaff::find()->where(['uphostery_id' => $id])->andWhere(['staff_type' => 'final inspector'])->one();
        return $this->render('print-caa', [
            'uphosteryPart' => $uphosteryPart,
            'model' => $model,
            'arc' => $arc,
            'inspector' => $inspector,
        ]);
    }
    /**
     * print CAA
     * @param integer $id
     * @return mixed
     */
    public function actionPrintFaa($id,$uphostery_part_id)
    {   
        $this->layout = 'print-arc';
        $model = Uphostery::find()->where(['id' => $id])->one();
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $arc = UphosteryArc::find()->where(['type' => 'FAA'])->andWhere(['uphostery_id' => $id])->one();
        $inspector = UphosteryStaff::find()->where(['uphostery_id' => $id])->andWhere(['staff_type' => 'final inspector'])->one();
        return $this->render('print-faa', [
            'uphosteryPart' => $uphosteryPart,
            'model' => $model,
            'arc' => $arc,
            'inspector' => $inspector,
        ]);
    }
    /**
     * print CAA
     * @param integer $id
     * @return mixed
     */
    public function actionPrintEasa($id,$uphostery_part_id)
    {   
        $this->layout = 'print-arc';
        $model = Uphostery::find()->where(['id' => $id])->one();
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $arc = UphosteryArc::find()->where(['type' => 'EASA'])->andWhere(['uphostery_id' => $id])->one();
        $inspector = UphosteryStaff::find()->where(['uphostery_id' => $id])->andWhere(['staff_type' => 'final inspector'])->one();
        return $this->render('print-easa', [
            'uphosteryPart' => $uphosteryPart,
            'model' => $model,
            'arc' => $arc,
            'inspector' => $inspector,
        ]);
    }
    public function actionPrintCoc($id,$uphostery_part_id)
    {   
        $this->layout = 'print-arc';
        $model = Uphostery::find()->where(['id' => $id])->one();
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $arc = UphosteryArc::find()->where(['type' => 'COC'])->andWhere(['uphostery_id' => $id])->one();
        $inspector = UphosteryStaff::find()->where(['uphostery_id' => $id])->andWhere(['staff_type' => 'final inspector'])->one();
        return $this->render('print-coc', [
            'uphosteryPart' => $uphosteryPart,
            'model' => $model,
            'arc' => $arc,
            'inspector' => $inspector,
        ]);
    }
    public function actionPrintCaav($id,$uphostery_part_id)
    {   
        $this->layout = 'print-arc';
        $model = Uphostery::find()->where(['id' => $id])->one();
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $arc = UphosteryArc::find()->where(['type' => 'CAAV'])->andWhere(['uphostery_id' => $id])->one();
        $inspector = UphosteryStaff::find()->where(['uphostery_id' => $id])->andWhere(['staff_type' => 'final inspector'])->one();
        return $this->render('print-caav', [
            'uphosteryPart' => $uphosteryPart,
            'model' => $model,
            'arc' => $arc,
            'inspector' => $inspector,
        ]);
    }
    public function actionPrintDcam($id,$uphostery_part_id)
    {   
        $this->layout = 'print-arc';
        $model = Uphostery::find()->where(['id' => $id])->one();
        $uphosteryPart = UphosteryPart::getUphosteryPartById($uphostery_part_id);
        $arc = UphosteryArc::find()->where(['type' => 'DCAM'])->andWhere(['uphostery_id' => $id])->one();
        $inspector = UphosteryStaff::find()->where(['uphostery_id' => $id])->andWhere(['staff_type' => 'final inspector'])->one();
        return $this->render('print-dcam', [
            'uphosteryPart' => $uphosteryPart,
            'model' => $model,
            'arc' => $arc,
            'inspector' => $inspector,
        ]);
    }

}
