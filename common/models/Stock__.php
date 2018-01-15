<?php

namespace common\models;
use common\models\Part;
use common\models\Supplier;
use common\models\User;
use common\models\StockHistory;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "stock".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $part_id
 * @property string $desc
 * @property string $storage_area
 * @property string $batch_no
 * @property string $note
 * @property integer $quantity
 * @property string $unit_price
 * @property string $expiration_date
 * @property integer $status
 */
class Stock extends \yii\db\ActiveRecord
{
    public $total_quantity;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'purchase_order_id','part_id', 'shelf_life','hour_used','receiver_no','storage_location_id','unit_id','sub_unit_id','currency_id'], 'integer'],
            [['unit_price','usd_price','freight','quantity'], 'number'],
            [['expiration_date','received','total_quantity','last_cali', 'status', 'next_cali'], 'safe'],
            [['desc', 'note'], 'string', 'max' => 255],
            [['batch_no'], 'string', 'max' => 10],
            [['part_id', 'quantity', 'storage_location_id','unit_id'], 'required'],
            // [['quantity'], 'each', 'rule' => ['required']],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => 'Supplier ID',
            'part_id' => 'Part ID',
            'desc' => 'Description',
            'storage_id' => 'Storage Area',
            'shelf_life' => 'Shelf Life (Hours)',
            'batch_no' => 'Batch/Lot No',
            'note' => 'Note',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'expiration_date' => 'Expiration Date',
            'status' => 'Status',
            'last_cali' => 'Last Calibration',
            'next_cali' => 'Next Calibration',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorageLocation()
    {
        return $this->hasOne(StorageLocation::className(), ['id' => 'storage_location_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPart()
    {
        return $this->hasOne(Part::className(), ['id' => 'part_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrder()
    {
        return $this->hasOne(PurchaseOrder::className(), ['id' => 'purchase_order_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by'])->from(['created_by' => User::tableName()]);
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by'])->from(['updated_by' => User::tableName()]);
    }
    public function getStorage()
    {
        return $this->hasOne(StorageLocation::className(), ['id' => 'storage_location_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id'])->from(['unit_id' => Unit::tableName()]);
    }
    public static function getStockBatch($id) {
        $stock = Stock::find()->where(['id' => $id])->one();

        return !empty($stock->batch_no)?$stock->batch_no:'';
    }

    public static function getStockLocationId($id) {
        $stock = Stock::find()->where(['id' => $id])->one();

        return !empty($stock->storage_location_id)?$stock->storage_location_id:false;
    }
    public static function getStock($id) {
        return Stock::find()->where(['id' => $id])->one();
    }
    public static function getStockByPartId($part_id) {
        return Stock::find()->where(['part_id' => $part_id])->andWhere(['status' => 'active'])->all();
    }
    /*  
        checkStock function 
        get stock id and return in array 
        there will be multiple stock_id
    */
    public static function checkStock($partId,$quantitySelected) {
        $stocks = Stock::find()->where(['part_id' => $partId])->andWhere(['>','quantity','0'])->all();
        $data = array();
        $quantityNeeded = $quantitySelected;
        foreach ($stocks as $stock){
            $stockId = $stock->id;
            /* if quantity needed already fulfilled */
            if ( $quantityNeeded > 0 ) {
                $data['stock_id'][] = $stockId;
                $stockQuantity = $stock->quantity;
                /* if st_qty is enough for stock out */
                if ( $stockQuantity >= $quantityNeeded ) {
                    /* A :: stock 11 .... selected 10 */
                        /* deduct stock quantity see how much left */
                            $stockQuantity -= $quantityNeeded;

                            /* set how many quantity of stock used for this stock id */
                            $data['quantity_used'][] = $quantityNeeded;

                            /* set quantity to zero as the stock is already enough */
                            $quantityNeeded = 0;
                            /* A :: stockQuantity become 1 */


                } else if ( $stockQuantity < $quantityNeeded) {
                    /* B :: stock 10 .... selected 11 */
                        /* see how many more stock needed */
                            $quantityNeeded -= $stockQuantity;

                            /* set how many quantity of stock used for this stock id */
                            $data['quantity_used'][] = $stockQuantity;
                            
                            /* set stockQuantity to zero as all the stock will be used for the needed */
                            $stockQuantity = 0;
                            /* A :: stockQuantity become 0 */
                }

                $data['stock_quantity'][] = $stockQuantity;

            }
        }
        
        return $data;
    } 
    /*  
        stock out function 
        get stock id and return in array 
        there will be multiple stock_id
    */
    public static function stockOutByPartId($partId,$quantityIssued) {
        $stocks = Stock::find()->where(['part_id' => $partId])->andWhere(['>','quantity','0'])->all();
        $data = array();
        foreach ($stocks as $stock){
            $stockId = $stock->id;
            /* if quantity needed already fulfilled */
            if ( $quantityIssued > 0 ) {
                $data['stock_id'][] = $stockId;
                $stockQuantity = $stock->quantity;
                /* if st_qty is enough for stock out */
                if ( $stockQuantity >= $quantityIssued ) {
                    /* A :: stock 11 .... selected 10 */
                        /* deduct stock quantity see how much left */
                            $stockQuantity -= $quantityIssued;

                            /* set how many quantity of stock used for this stock id */
                            $data['qty_issued'][] = $quantityIssued;

                            /* set quantity to zero as the stock is already enough */
                            $quantityIssued = 0;
                            /* A :: stockQuantity become 1 */
                } else if ( $stockQuantity < $quantityIssued) {
                    /* B :: stock 10 .... selected 11 */
                        /* see how many more stock needed */
                            $quantityIssued -= $stockQuantity;

                            /* set how many quantity of stock used for this stock id */
                            $data['qty_issued'][] = $stockQuantity;
                            
                            /* set stockQuantity to zero as all the stock will be used for the needed */
                            $stockQuantity = 0;
                            /* A :: stockQuantity become 0 */
                }
                /* AB :: update stock quantity */
                $updateStock = Stock::find()->where(['id' => $stockId])->one();
                $updateStock->quantity = $stockQuantity;
                $updateStock->save();
                $data['stock_quantity'][] = $stockQuantity;
            }
        }
        
        return $data;
    }
    /*  
        stock out function 
        get stock id and return in array 
        there will be multiple stock_id
    */
    public static function stockOutByStockId($stockId,$quantityIssued) {
        $stock = Stock::find()->where(['id' => $stockId])->one();
        $data = array();
        $stockQuantity = $stock->quantity;
        $stockQuantity = $stockQuantity - $quantityIssued;
        $stock->quantity = $stockQuantity;
        $stock->save();
        $data['stock_quantity'][] = $stockQuantity;
        
        return $data;
    }
    /*  
        stockReturn function 
        get stock id and return in array 
        there will be multiple stock_id
    */
    public static function stockReturn($stock_id,$qty_returned,$hour_used) {
        $updateStock = Stock::find()->where(['id' => $stock_id])->one();
        $currentQty = $updateStock->quantity;
        $updateStock->quantity = $currentQty + $qty_returned;
        $currentHourUsed = $updateStock->hour_used;
        $updateStock->hour_used = $currentHourUsed + $hour_used;
        $updateStock->save();
        return $updateStock->quantity;
    }
    public static function checkReceived($po_id) {
        $data = array();
        $data['allReceivedStatus'] = true;
        $data['purchaseOrder'] = false;
        $data['purchaseOrderDetail'] = false;
        if ( $po_id ) {
            if ( isset ($_GET['ty']) && $_GET['ty'] == 'part'){ 
                $purchaseOrder = PurchaseOrder::find()->where(['id' => $po_id])->one();
                $purchaseOrderDetail = PurchaseOrderDetail::find()->where(['purchase_order_id' => $po_id])->all();

                $checkAllReceived = Yii::$app->db->createCommand(
                                "SELECT quantity - received AS bal  FROM `purchase_order_detail` WHERE (`purchase_order_id`= $po_id) "
                                )->queryAll();
            } else {
                $purchaseOrder = GeneralPo::find()->where(['id' => $po_id])->one();
                $purchaseOrderDetail = GeneralPoDetail::find()->where(['general_po_id' => $po_id])->all();

                $checkAllReceived = Yii::$app->db->createCommand(
                                "SELECT quantity - received AS bal  FROM `general_po_detail` WHERE (`general_po_id`= $po_id) "
                                )->queryAll();

            }
            $allReceivedStatusArr = array();
            foreach ( $checkAllReceived as $key => $ccc ) {
                if ( $ccc['bal'] == 0 ) {
                    $allReceivedStatusArr[$key] = true;
                } else {
                    $allReceivedStatusArr[$key] = false;
                }
            }
            /* there is false meaning there still have remaining pod balance */
            if ( in_array(false, $allReceivedStatusArr) ) { 
                $data['allReceivedStatus'] = false;
                $data['purchaseOrder'] = $purchaseOrder;
                $data['purchaseOrderDetail'] = $purchaseOrderDetail;
            }
            return $data;
        }
        return false;
    }
    public static function saveStock($id,$model,$previousNo) {
        $data = array();
        foreach ( $model->part_id as $key => $partId ) {
            $podId = Yii::$app->request->post()['podid'][$key];
            $stockType = Yii::$app->request->post()['stock_type'][$key];
            $reusable = Yii::$app->request->post()['reusable'][$key];
            /* differentiate the stock type (part or tools ) */
                /* part stock */
                if ($stockType == 'part') {
                    // d($model);exit;
                    /* if quantity received > 0 then only save */
                    if ( $model->quantity[$key] > 0 ) { 
                        /* non-reusable */
                        $eachStock = new Stock();
                        $eachStock->receiver_no = $previousNo;
                        $eachStock->purchase_order_id = $id;
                        $eachStock->supplier_id = $model->supplier_id;
                        $eachStock->received = $model->received;
                        $eachStock->part_id = $partId;
                        $eachStock->shelf_life = $model->shelf_life[$key];
                        $eachStock->batch_no = $model->batch_no[$key];
                        $eachStock->quantity = $model->quantity[$key];
                        $eachStock->unit_id = $model->unit_id[$key];
                        $eachStock->unit_price = $model->unit_price[$key];
                        $eachStock->last_cali = $model->last_cali[$key];
                        $eachStock->next_cali = $model->next_cali[$key];
                        $eachStock->currency_id = $model->currency_id[$key];
                        $eachStock->usd_price = $model->usd_price[$key];
                        $eachStock->expiration_date = $model->expiration_date[$key];
                        $eachStock->note = $model->note[$key];
                        $eachStock->storage_location_id = $model->storage_location_id[$key];
                        $eachStock->created_by = Yii::$app->user->identity->id;
                        $eachStock->created = date("Y-m-d H:i:s");
                        $eachStock->save();
                        $quantityToCheck = $model->quantity[$key];

                        /* update stock history */
                        $stockHistory = new StockHistory();
                        $stockHistory->part_id = $partId;
                        $stockHistory->reference_no = $id;
                        $stockHistory->related_user = Yii::$app->user->identity->id;
                        $stockHistory->reference_no = $id;
                        $stockHistory->datetime = date("Y-m-d H:i:s");
                        $stockHistory->save();



                    } /* if quantity received > 0 */
                } /* if is stock type "part" */
                /* part stock */
                else if ($stockType == 'tool') {
                    /* if quantity received > 0 then only save */
                    $quantityToCheck = $model->quantity[$key];
                    if(isset(Yii::$app->request->post()['stock_in'][$key])){

                        if ( $model->quantity[$key] > 0 ) { 
                            /* each of the quantity will have one stock record */
                                $eachStock = new Tool();
                                $eachStock->receiver_no = $previousNo;

                                $eachStock->general_po_id = $id;
                                $eachStock->supplier_id = $model->supplier_id;
                                $eachStock->received = $model->received;
                                $eachStock->part_id = $partId;
                                $eachStock->shelf_life = $model->shelf_life[$key];
                                $eachStock->batch_no = $model->batch_no[$key];
                                $eachStock->quantity = $model->quantity[$key];
                                $eachStock->unit_id = $model->unit_id[$key];
                                $eachStock->unit_price = $model->unit_price[$key];
                                $eachStock->expiration_date = $model->expiration_date[$key];
                                $eachStock->note = $model->note[$key];
                                $eachStock->last_cali = $model->last_cali[$key];
                                $eachStock->next_cali = $model->next_cali[$key];
                                $eachStock->storage_location_id = $model->storage_location_id[$key];

                                $eachStock->created_by = Yii::$app->user->identity->id;
                                $eachStock->created = date("Y-m-d H:i:s");

                                $eachStock->save();

                        }/* if quantity received > 0 */

                    }/* if need to update stock */

                } /* if is stock type "tool" */

            

            /* standby for checking whether close PO */
            if($stockType == 'part') {
                $pod = PurchaseOrderDetail::find()->where(['id' => $podId])->one();
                $podReceived = $pod->received;
                $podReceived += $quantityToCheck;
                $pod->received = $podReceived;

                $pod->save();
            } else {
                $pod = GeneralPoDetail::find()->where(['id' => $podId])->one();
                $podReceived = $pod->received;
                $podReceived += $quantityToCheck;
                $pod->received = $podReceived;

                $pod->save();
            }


            $checkPOItemQuantity[$podId] = $pod->quantity;
            $checkPOItemReceived[$podId] = $pod->received;

        }  /*  foreach part */

        $data['checkPOItemQuantity'] = $checkPOItemQuantity;
        $data['checkPOItemReceived'] = $checkPOItemReceived;
        $data['stockType'] = $stockType;
        $data['podId'] = $podId;

        return $data;
    }

    public static function getLowStock() {
        /* get low stock */
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
                if ( number_format($stockQtyTotal['sumsQ'], 3, '.', '') >= $stockQuery[$key]['restock'] ) {
                    unset($stockQuery[$key]);
                } else {
                    $stockQuery[$key]['sumsQ'] = number_format($stockQtyTotal['sumsQ'], 3, '.', '');
                    $stockQuery[$key]['unit_id'] = $dataUnit[$stockQtyTotal['unit_id']];
                }
            }


        /* get result data here */
            $data['dataProvider'] = [
                'key'=>'id',
                'pagination' => [
                    'pageSize' => 20,
                ],
                'allModels' => $stockQuery,
                'sort' => [
                    'attributes' => ['part_id'],
                ],
            ];
            $data['stockQuery'] = $stockQuery;



            return $data;
    }
}
