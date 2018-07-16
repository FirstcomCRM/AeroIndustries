<?php

namespace backend\controllers;

use Yii;
use common\models\Stock;
use common\models\Tool;
use common\models\StockAttachment;
use common\models\SearchStock;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use common\models\Unit;
use common\models\Part;
use common\models\PartAttachment;
use common\models\PurchaseOrder;
use common\models\PurchaseOrderDetail;
use common\models\PurchaseOrderAttachment;
use common\models\ToolPo;
use common\models\ToolPoDetail;
use common\models\Setting;
use common\models\Supplier;
use common\models\StorageLocation;
use common\models\Currency;

use yii\data\ArrayDataProvider;
/**
 * StockController implements the CRUD actions for Stock model.
 */
class StockController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');

        foreach ( $userGroupArray as $uGId => $uGName ){
            $permission = UserPermission::find()->where(['controller' => 'Stock'])->andWhere(['user_group_id' => $uGId ] )->all();
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
/*
* CRUD
*/
    /**
     * Lists all Stock models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchStock();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Deletes an existing Stock model.
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
     * Finds the Stock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stock::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

/* STOCK */
        /**
         * Lists all Stock by parts.
         * @return mixed
         */
        public function actionStock()
        {
            /* filters */
                $filter = '';
                if ( isset( $_GET['cat_id'] ) && !empty ( $_GET['cat_id'] ) ) {
                    $catId = $_GET['cat_id'];
                    $filter .= " AND p.category_id = $catId ";
                }
                if ( isset( $_GET['part_id'] ) && !empty ( $_GET['part_id'] ) ) {
                    $partId = $_GET['part_id'];
                    $filter .= " AND p.id = $partId ";
                }

            $dataUnit = ArrayHelper::map(Unit::find()->where(['<>','status','inactive'])->all(), 'id', 'unit');
            /* custom sql query */
                $sqlQuery = "
                            SELECT
                                s.id,
                                s.part_id,
                                p.part_no,
                                p.restock,
                                p.manufacturer
                            FROM
                                stock s,
                                part p
                            WHERE
                                s.part_id = p.id AND
                                s.status = 'active'
                                $filter
                            GROUP by
                                s.part_id
                        ";

                $stockQuery = Yii::$app->db->createCommand($sqlQuery)->queryAll();
                // d($stockQuery);exit;
            /* custom sql query for grand total only */
                foreach ( $stockQuery as $key => $sQ){
                    $partId = $sQ['part_id'];
                    $sqlQueryTotal = "
                                SELECT
                                    sum(quantity) sumsQ,
                                    unit_id
                                FROM
                                    stock s
                                WHERE
                                    s.status = 'active' AND
                                    s.part_id = $partId
                            ";
                    $stockQtyTotal = Yii::$app->db->createCommand($sqlQueryTotal)->queryOne();
                    $stockQuery[$key]['sumsQ'] = number_format($stockQtyTotal['sumsQ'], 3, '.', '');
                    $stockQuery[$key]['unit_id'] = $dataUnit[$stockQtyTotal['unit_id']];
                }


            /* get result data here */
                $dataProvider = new ArrayDataProvider([
                    'key'=>'id',
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                    'allModels' => $stockQuery,
                    'sort' => [
                        'attributes' => ['part_id'],
                    ],
                ]);


            return $this->render('stock', [
                'dataProvider' => $dataProvider,
                'stockQuery' => $stockQuery,
            ]);
        }

        /**
         * Lists all Stock by parts.
         * @return mixed
         */
        public function actionInventoryReport()
        {
            $searchModel = new SearchStock();
            $dataProvider = $searchModel->searchInventory(Yii::$app->request->queryParams);

            return $this->render('inventory-report', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Preview Stock and its history
         * @param integer $id
         * @return mixed
         */
        public function actionPreviewStock($id)
        {
            $attachment = new StockAttachment();
            $oldAttachment = StockAttachment::find()->where(['stock_id' => $id])->all();
            $model = $this->findModel($id);
            $partId = $model->part_id;
            $stockPart = Stock::find()->where(['part_id' => $model->part_id])->all();

                $searchModel = new SearchStock();
                $dataProvider = $searchModel->searchStock($partId, Yii::$app->request->queryParams);


            return $this->render('preview-stock', [
                'stockPart' => $stockPart,
                'model' => $model,
                'attachment' => $attachment,
                'dataProvider' => $dataProvider,
                'oldAttachment' => $oldAttachment,
            ]);
        }




/*
* CUSTOM
*/

    /**
     * Creates a new stock.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * $id = PO id
     * @return mixed
     */
    public function actionNew( $id = null )
    {
        $model = new Stock();
        $poAttachment = new PurchaseOrderAttachment();
        $purchaseOrder = false;
        $purchaseOrderDetail = false;
        $allReceivedStatus = true;
        $allReceivedStatusArr = array();

        $dataCheckReceived = Stock::checkReceived($id);
        $purchaseOrder = $dataCheckReceived['purchaseOrder'];
        $purchaseOrderDetail = $dataCheckReceived['purchaseOrderDetail'];
        $allReceivedStatus = $dataCheckReceived['allReceivedStatus'];

        if ( $model->load(Yii::$app->request->post()) ) {
        /* if load model */
            // dx(Yii::$app->request->post());
            if ( !empty ( $model->part_id ) ) {
                    $freight = 0;
                    $previousNo = 0;
                    $rec1 = 0;
                    $rec2 = 0;
                    $recNo = Stock::find()->where(['status'=>'active'])->orderBy('receiver_no DESC')->limit(1)->one();
                    $toolrecNo = Tool::find()->where(['status'=>'active'])->orderBy('receiver_no DESC')->limit(1)->one();
                    if ( !empty ( $recNo ) ) {
                        $rec1 = $recNo->receiver_no;
                    }
                    if ( !empty ( $toolrecNo ) ) {
                        $rec2 = $toolrecNo->receiver_no;
                    }
                    if ( $rec1 >= $rec2 ) {
                        $previousNo = $rec1;
                    } else if ( $rec2 >= $rec1 ){
                        $previousNo = $rec2;
                    } else {
                        $previousNo = 0;
                    }
                    $previousNo += 1;
                /* save stock */
                    $dataSaveStock = Stock::saveStock($id,$model,$previousNo);
                    $checkPOItemQuantity = $dataSaveStock['checkPOItemQuantity'];
                    $checkPOItemReceived = $dataSaveStock['checkPOItemReceived'];
                    $stockType = $dataSaveStock['stockType'];
                    $podId = $dataSaveStock['podId'];
                /* if all the item has been received, close the PO */
                    $allReceived = [];
                    foreach ($checkPOItemQuantity as $podId => $qty ) {
                        $allReceived[$podId] = false;
                        /* if the quantity received is higher or equal to the po received quantity, means all clear, so true */
                        if ( $qty <= $checkPOItemReceived[$podId] ) {
                            $allReceived[$podId] = true;
                        }
                    }

                    /* there is false meaning there still have remaining pod balance */
                    if ( ! in_array(false, $allReceived) ) {

                        $purchaseOrder->approved = 'closed';
                        $purchaseOrder->save();
                       
                        if($stockType == 'part') {
                            Yii::$app->getSession()->setFlash('success', "Stock updated! All the item from " . PurchaseOrder::getPONo($purchaseOrder->purchase_order_no,$purchaseOrder->created) . ' were received, PO Closed!');
                        } else {
                            Yii::$app->getSession()->setFlash('success', "Stock updated! All the item from " . ToolPo::getTPONo($purchaseOrder->purchase_order_no,$purchaseOrder->created). ' were received, PO Closed!');
                        }
                        //edrEmailCompose
                        // $this->composeEmail($purchaseOrder);
                        $allReceivedStatus = true;
                    } else {
                        Yii::$app->getSession()->setFlash('success', 'Stock updated!');
                    }

                    return $this->redirect(['new', 'id' => $id,'r_n' => $previousNo]);
            }
        /* if load model ended */
        }

        return $this->render('new', [
            'poAttachment' => $poAttachment,
            'model' => $model,
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderDetail' => $purchaseOrderDetail,
            'allReceivedStatus' => $allReceivedStatus,
        ]);

    }

    /**
     * Updates an existing Stock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        $attachment = new StockAttachment();
        $oldAttachment = StockAttachment::find()->where(['stock_id' => $id])->all();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->updated_by = Yii::$app->user->identity->id;
            $currentDateTime = date("Y-m-d H:i:s");
            $model->updated = $currentDateTime;

            if ($model->save()) {
                $stockId = $model->id;

                if ( $attachment->load(Yii::$app->request->post()) ) {
                    $attachment->attachment = UploadedFile::getInstances($attachment, 'attachment');
                    foreach ($attachment->attachment as $file) {
                        $fileName = md5(date("YmdHis")).'-'.$file->name;
                        $attachmentClass = explode('\\', get_class($attachment))[2];
                        $file->saveAs('uploads/'.$attachmentClass.'/'.$fileName);
                        /* image upload */
                        $stA = new StockAttachment();
                        $stA->stock_id = $stockId;
                        $stA->value = $fileName;
                        $stA->save();

                    }

                }


                return $this->redirect(['preview', 'id' => $model->id]);
            }
        }
        return $this->render('edit', [
            'model' => $model,
            'attachment' => $attachment,
            'oldAttachment' => $oldAttachment,
        ]);

    }


    /**
     * View Stock and its details
     * @param integer $id
     * @return mixed
     */
    public function actionPreview($id)
    {
        $attachment = new StockAttachment();
        $oldAttachment = StockAttachment::find()->where(['stock_id' => $id])->all();
        $model = $this->findModel($id);
        $stockAttachment = PurchaseOrderAttachment::find()->where(['purchase_order_id' => $model->purchase_order_id ])->andWhere(['type' => 'stock_in_attachment'])->all();
        $otherBatches = Stock::find()->where(['part_id' => $model->part_id])->andWhere(['<>','id', $id])->all();

        $otherBatchesQty = 0;
        $otherBatchesTotalQty = 0;
        foreach ( $otherBatches as $oB ) {
            $otherBatchesQty += $oB->quantity;
            $otherBatchesTotalQty += $oB->quantity ;
        }

        if ( $attachment->load(Yii::$app->request->post()) ) {
            $attachment->attachment = UploadedFile::getInstances($attachment, 'attachment');

            foreach ($attachment->attachment as $file) {

                $fileName = md5(date("YmdHis")).'-'.$file->name;
                $conAttachmentClass = explode('\\', get_class($attachment))[2];
                $file->saveAs('uploads/'.$conAttachmentClass.'/'.$fileName);
                /* image upload */
                $conA = new StockAttachment();
                $conA->stock_id = $id;
                $conA->value = $fileName;
                if ( $conA->save() ){
                    Yii::$app->getSession()->setFlash('success', 'Attachment uploaded!');
                }

            }
            return $this->redirect(['preview', 'id' => $id]);
        }

        return $this->render('preview', [
            'model' => $model,
            'attachment' => $attachment,
            'stockAttachment' => $stockAttachment,
            'oldAttachment' => $oldAttachment,
            'otherBatchesQty' => $otherBatchesQty,
            'otherBatchesTotalQty' => $otherBatchesTotalQty,
        ]);
    }

    /* to enable ajax function */
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }





    /**
     * Receiver for stock and its details
     * @param integer $id = receiver_no.
     * @return mixed
     */
    public function actionReceiver($id)
    {
        $this->layout = 'print';
        $model = Stock::find()->where(['receiver_no' => $id])->groupBy(['part_id'])->all();
        $model2 = Tool::find()->where(['receiver_no' => $id])->groupBy(['part_id'])->all();

        $toolQty = [];
        foreach ( $model2 as $m ) {
            $partId = $m->part_id;
            $toolQty[$m->id] = Tool::find()->where(['part_id' => $partId])->andWhere(['receiver_no' => $id])->count();
        }


        if ( $model ) {
            $isTool = false;
            $poId = $model[0]->purchase_order_id;
            $reNumber = $model[0]->receiver_no;
            $supplierId = $model[0]->supplier_id;
            $receiveDate = $model[0]->received;
            $po = PurchaseOrder::find()->where(['id' => $poId])->one();
        } else if ($model2 ) {
            $isTool = true;
            $poId = $model2[0]->tool_po_id;
            $reNumber = $model2[0]->receiver_no;
            $supplierId = $model2[0]->supplier_id;
            $receiveDate = $model2[0]->received;
            $po = ToolPo::find()->where(['id' => $poId])->one();
        }

        return $this->render('receiver', [
            'model' => $model,
            'model2' => $model2,
            'po' => $po,
            'toolQty' => $toolQty,
            'reNumber' => $reNumber,
            'receiveDate' => $receiveDate,
            'supplierId' => $supplierId,
            'isTool' => $isTool,
        ]);
    }
    /**
     * Print for stock
     * @param integer $id = receiver_no .
     * @return mixed
     */
    public function actionPrintSticker($id)
    {
        /* get models  */
        $receiverNo = $id;
        $stockWithTheSameReceiverNo = [];

        if ( $id ) {
            $stockWithTheSameReceiverNo = Stock::find()->where(['receiver_no' => $receiverNo])->all();
            /* receiver no will not be duplicated for stock and tool, they are using same running no. */
            $isTool = false;
            if ( empty($stockWithTheSameReceiverNo ) ) {
                $isTool = true;
                $stockWithTheSameReceiverNo = Tool::find()->where(['receiver_no' => $receiverNo])->groupBy('part_id')->all();
            }
            // $stockWithTheSameReceiverNo[] = Tool::find()->where(['receiver_no' => $receiverNo])->groupBy('part_id')->all();
            $toolQty = Tool::find()->where(['receiver_no' => $receiverNo])->count();
        }

        $stockWithTheSameReceiverNo = array_filter($stockWithTheSameReceiverNo);
        $stockWithTheSameReceiverNo = array_slice($stockWithTheSameReceiverNo, 0 );

        return $this->render('print-sticker', [
            'receiverNo' => $receiverNo,
            'isTool' => $isTool,
            'stockWithTheSameReceiverNo' => $stockWithTheSameReceiverNo,
            'subTitle' => 'Print Receiver',
            'toolQty' => $toolQty,
        ]);

    }
    /**
     * Sticker for stock
     * @param integer $id = stock id .
     * @return mixed
     */
    public function actionSticker($id,$q,$pt)
    {
        $this->layout = 'print';

        $type = Part::find()->where(['id' => $pt])->one()->type;

        if ( $type == 'part' ) {
            $model = $this->findModel($id);
            $poId = $model->purchase_order_id;
            $receiverNo = $model->receiver_no;
            $po = PurchaseOrder::find()->where(['id' => $poId])->one();
        } else {
            $model = Tool::find()->where(['id' => $id])->one();
            $poId = $model->tool_po_id;
            $receiverNo = $model->receiver_no;
            $po = ToolPo::find()->where(['id' => $poId])->one();
        }

        return $this->render('sticker', [
            'model' => $model,
            'po' => $po,
            'q' => $q,
        ]);
    }

/**
 *
 *
 *  AJAX FUNCTION.
 *
 */

    /**
     * get qty available for work order stock out
     *
     */

    public function actionAjaxCheckstock()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            // d(Yii::$app->request->post());exit;
            $partId = 0;

            if ( isset ( Yii::$app->request->post()['selectedStockPartId'] ) ) {
                $partId = Yii::$app->request->post()['selectedStockPartId'];
            }
            $part = Part::getPart($partId);
            $partType = $part->type;
            $partQ = Yii::$app->db->createCommand("SELECT sum(quantity) qty FROM stock WHERE part_id = $partId");
            $sumQ = $partQ->queryScalar();

            $data['stQty'] = 0;
            $data['partType'] = $partType;

            if ( $partQ ) {
                $data['stQty'] = $sumQ;
                $data['partId'] = $partId;
            }
            $data = json_encode($data);
            return $data;
        }
    }

    /**
     * get qty available for work order stock out
     *
     */

    public function actionAjaxAddstock()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            // d(Yii::$app->request->post());exit;
            $postData = Yii::$app->request->post();

            $soQty = 0;
            $soSubQty = 0;

            $stQty = 0;
            $stSubQty = 0;

            $soPartId = 0;
            $soRemark = '';

            $n = 0;

            if ( !empty ( $postData['soPartId'] ) ) {
                $soPartId = $postData['soPartId'];
            }
            if ( !empty ( $postData['soQty'] ) ) {
                $soQty = $postData['soQty'];
            }
            if ( !empty ( $postData['soSubQty'] ) ) {
                $soSubQty = $postData['soSubQty'];
            }
            if ( !empty ( $postData['stQty'] ) ) {
                $stQty = $postData['stQty'];
            }
            if ( !empty ( $postData['stSubQty'] ) ) {
                $stSubQty = $postData['stSubQty'];
            }
            if ( !empty ( $postData['soRemark'] ) ) {
                $soRemark = $postData['soRemark'];
            }
            if ( !empty ( $postData['soUom'] ) ) {
                $soUom = $postData['soUom'];
            }
            if ( !empty ( $postData['n'] ) ) {
                $n = $postData['n'];

            }
            return $this->render('ajax-addstock', [
                'soPartId' => $soPartId,
                'soRemark' => $soRemark,
                'soQty' => $soQty,
                'soUom' => $soUom,
                'soSubQty' => $soSubQty,
                'stQty' => $stQty,
                'stSubQty' => $stSubQty,
                'n' => $n,
            ]);
        }
    }
    /**
     * stock info from ajax
     *
     */

    public function actionGetStockinfo()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $postData = Yii::$app->request->post();
            $stockid = $postData['stockid'];

            $getStock = Stock::getStock($stockid);
            $shelf_life = $getStock->shelf_life;
            $part_id = $getStock->part_id;
            $batch_no = $getStock->batch_no;
            $hour_used = $getStock->hour_used;
            $expiration_date = $getStock->expiration_date;

            return $this->render('get-stockinfo', [
                'shelf_life' => $shelf_life,
                'part_id' => $part_id,
                'batch_no' => $batch_no,
                'hour_used' => $hour_used,
                'expiration_date' => $expiration_date,
            ]);
        }
    }
    /**
     * stock part from ajax
     *
     */

    public function actionGetStockdropdown()
    {
        $this->layout = false;
        if ( Yii::$app->request->post() ) {
            $postData = Yii::$app->request->post();
            $partid = $postData['partid'];

            $getStock = Stock::getStockByPartId($partid);
            $stockDropdown = array();
            $dataPart = Part::dataPart();
            foreach ($getStock as $eS ):
                $stockDropdown[$eS->id] = $dataPart[$eS->part_id] .' ('.$eS->hour_used.' - '. $eS->expiration_date.' - ' . $eS->batch_no .' - ' . $eS->shelf_life . ') - '. $eS->id;
            endforeach;

            return $this->render('get-stockdropdown', [
                'stockDropdown' => $stockDropdown,
            ]);
        }
    }

    /*
    * Function that sends an email notificaton when stocks has been received
    */
    protected function composeEmail($purchaseOrder){
      $data = Setting::find()->where(['name'=>'Stocks Received Email Notification'])->one();
      $message = '<p>Testing mssage in gmail smtp</p>';
      //$data = Yii::$app->mailer->compose('email_notif',['purchaseOrder'=>$purchaseOrder])
      $data = Yii::$app->mailer->compose(['html'=>'email_notif'],['purchaseOrder'=>$purchaseOrder])
      ->setTo($data->value)
    //    ->setTo('eumerjoseph.ramos@yahoo.com')
      ->setFrom(['info@aeriindustriesdemo.com' => 'info@aeriindustriesdemo.com'])
      ->setSubject('Stocks Received')
    //  ->setHtmlBody($message)
      ->send();
    }

    public function actionPartImage($id){
      $parts = PartAttachment::find()->where(['part_id'=>$id])->asArray()->all();
      return $this->renderAjax('part-image',[
        'id'=>$id,
        'parts'=>$parts,
      ]);
    }
    public function actionImportExcel() {
        $model = new Stock();
        if ( $model->load( Yii::$app->request->post() ) ) {
            $model->attachment = UploadedFile::getInstances($model, 'attachment');
            foreach ($model->attachment as $file) {
                $fileName = md5(date("YmdHis")).'-'.$file->name;
                $file->saveAs('uploads/stock/'.$fileName);
            }
            $inputFile = "uploads/stock/$fileName";
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

            $dataSupplier = Supplier::dataSupplier();
            $dataLocation = StorageLocation::dataLocation();
            $dataUnit = Unit::dataUnit();
            $dataPart = Part::dataPart();
            $dataCurrencyISO = Currency::dataCurrencyISO();

            for ( $row = 2 ; $row <= $highestRow ; $row ++ ) {
                $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
                $data = $rowData[0];

                $supplier_name = $data[0];
                $storage_location = $data[1];
                $part_name = $data[2];
                $unit = $data[7];
                $currency = $data[8];
                $supplier_id = 0;
                $unit_id = 0;
                $part_id = 0;
                $category_id = 0;
                $storage_location_id = 0;
                $error = array();

                if (!in_array(trim($supplier_name), $dataSupplier)){
                    $error[] = true;
                } else {
                    $supplier_id = array_search(trim($supplier_name), $dataSupplier);
                }
                
                if (!in_array(trim($storage_location), $dataLocation)){
                    $error[] = true;
                } else {
                    $storage_location_id = array_search(trim($storage_location), $dataLocation);
                }
                
                if (!in_array(trim($part_name), $dataPart)){
                    $error[] = true;
                } else {
                    $part_id = array_search(trim($part_name), $dataPart);
                }

                if (!in_array(trim($unit), $dataUnit)){
                    $error[] = true;
                } else {
                    $unit_id = array_search(trim($unit), $dataUnit);
                }

                if (!in_array(trim($currency), $dataCurrencyISO)){
                    $error[] = true;
                } else {
                    $currency_id = array_search(trim($currency), $dataCurrencyISO);
                }


                $previousNo = 0;
                $rec1 = 0;
                $rec2 = 0;
                $recNo = Stock::find()->where(['status'=>'active'])->orderBy('receiver_no DESC')->limit(1)->one();
                $toolrecNo = Tool::find()->where(['status'=>'active'])->orderBy('receiver_no DESC')->limit(1)->one();
                if ( !empty ( $recNo ) ) {
                    $rec1 = $recNo->receiver_no;
                }
                if ( !empty ( $toolrecNo ) ) {
                    $rec2 = $toolrecNo->receiver_no;
                }
                if ( $rec1 >= $rec2 ) {
                    $previousNo = $rec1;
                } else if ( $rec2 >= $rec1 ){
                    $previousNo = $rec2;
                } else {
                    $previousNo = 0;
                }
                $previousNo += 1;

                if( !in_array(true, $error) ) {
                    $expiration_date = date('Y-m-d',strtotime($data[12]));
                    $stock = new Stock();
                    $stock->supplier_id = $supplier_id;
                    $stock->storage_location_id = $storage_location_id;
                    $stock->purchase_order_id = 0;
                    $stock->receiver_no = $previousNo;
                    $stock->part_id = $part_id;
                    $stock->desc = $data[3];
                    $stock->batch_no = $data[4];
                    $stock->note = $data[5];
                    $stock->quantity = $data[6];
                    $stock->unit_id = $unit_id;
                    $stock->currency_id = $currency_id;
                    $stock->unit_price = $data[9];
                    $stock->usd_price = $data[10];
                    $stock->freight = $data[11];
                    $stock->expiration_date = $expiration_date;
                    $stock->hour_used = $data[13];
                    $stock->shelf_life = $data[14];
                    $stock->status = $data[15];
                    $stock->created = date("Y-m-d H:i:s");
                    $stock->created_by = Yii::$app->user->identity->id;
                    $stock->save();
                }
            }
            if( !in_array(true, $error) ) {
                Yii::$app->getSession()->setFlash('success', 'Import Completed');
            } else {
                Yii::$app->getSession()->setFlash('danger', 'Import Incomplete');
            }
            return $this->redirect(['import-excel']);
        }
        return $this->render('import-excel',[
            'model' => $model
        ]);
    }

}
