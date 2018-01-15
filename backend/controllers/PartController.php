<?php

namespace backend\controllers;

use Yii;
use common\models\Part;
use common\models\SearchPart;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\Supplier;
use common\models\Unit;
use common\models\PartCategory;
use yii\web\UploadedFile;

/**
 * PartController implements the CRUD actions for Part model.
 */
class PartController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Part'])->andWhere(['user_group_id' => $uGId ] )->all();
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
     * Lists all Part models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchPart();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Part model.
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
     * Creates a new Part model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Part();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->created = $currentDateTime;

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } 
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    /**
     * Updates an existing Part model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {

            $model->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->updated = $currentDateTime;
            
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } 
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    /**
     * Finds the Part model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Part the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Part::findOne($id)) !== null) {
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
            Yii::$app->getSession()->setFlash('success', 'Storage Location deleted');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Unable to delete Storage Location');
        }

        return $this->redirect(['index']);
    }
    public function actionImportExcel() {
        $model = new Part();
        if ( $model->load( Yii::$app->request->post() ) ) {
            $model->attachment = UploadedFile::getInstances($model, 'attachment');
            foreach ($model->attachment as $file) {
                $fileName = md5(date("YmdHis")).'-'.$file->name;
                $file->saveAs('uploads/part/'.$fileName);
            }
            $inputFile = "uploads/part/$fileName";
            $dataSupplier = Supplier::dataSupplier();
            $dataPartCategory = PartCategory::dataPartCategory();
            $dataUnit = Unit::dataUnit();
            try {
                $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFile);
            } catch (Exception $e){
                die('ERROR');
            }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $data = [];
            for ( $row = 2 ; $row <= $highestRow ; $row ++ ) {
                $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
                $data = $rowData[0];
                $unit_price = $data[6];
                $supplier_name = $data[1];
                $importable = true;
                if ( in_array($data[1], $dataSupplier) ){
                    $supplier_id = array_search($data[1], $dataSupplier);
                } else {
                    $importable = false;
                }
                if ( in_array($data[2], $dataPartCategory) ){
                    $unit_id = array_search($data[2], $dataPartCategory);
                } else {
                    $importable = false;
                }
                if ( in_array($data[5], $dataUnit) ){
                    $category_id = array_search($data[5], $dataUnit);
                } else {
                    $importable = false;
                }
                if( $importable ) {
                    $part = new Part();
                    $part->type = $data[0];
                    $part->supplier_id = $supplier_id;
                    $part->category_id = $category_id;
                    $part->part_no = $data[3];
                    $part->desc = $data[4];
                    $part->unit_id = $unit_id;
                    $part->default_unit_price = "$unit_price";
                    $part->restock = $data[7];
                    $part->manufacturer = $data[8];
                    $part->status = $data[9];
                    $part->is_shelf_life = $data[10];
                    $part->save();
                }
            }
            Yii::$app->getSession()->setFlash('success', 'Import Completed');
            return $this->redirect(['import-excel']);
        }
        return $this->render('import-excel',[
            'model' => $model
        ]);
    }
}
