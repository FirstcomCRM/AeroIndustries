<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tool".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $tool_po_id
 * @property integer $storage_location_id
 * @property integer $receiver_no
 * @property integer $part_id
 * @property string $desc
 * @property string $batch_no
 * @property string $note
 * @property integer $quantity
 * @property integer $sub_quantity
 * @property integer $unit_id
 * @property string $unit_price
 * @property integer $shelf_life
 * @property integer $hour_used
 * @property integer $time_used
 * @property string $expiration_date
 * @property integer $status
 * @property string $received
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 * @property integer $deleted
 */
class Tool extends \yii\db\ActiveRecord
{   
    public $qty;
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tool';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'tool_po_id', 'storage_location_id', 'receiver_no', 'part_id', 'currency_id', 'unit_id', 'shelf_life', 'hour_used', 'time_used', 'created_by', 'updated_by', 'deleted','in_used','work_order_id'], 'integer'],
            [['unit_price', 'quantity','usd_price','freight'], 'number'],
            [['expiration_date', 'received', 'created', 'updated','last_cali','next_cali','serial_no', 'status'], 'safe'],
            [['desc', 'note'], 'string', 'max' => 255],
            [['batch_no'], 'string', 'max' => 10],
            [['attachment'], 'file', 'maxFiles' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => 'Supplier',
            'tool_po_id' => 'Purchase Order No',
            'storage_location_id' => 'Storage Location',
            'receiver_no' => 'Receiver No',
            'part_id' => 'Part',
            'work_order_id' => 'Work Order',
            'desc' => 'Description',
            'batch_no' => 'Batch No',
            'note' => 'Note',
            'quantity' => 'Quantity',
            'unit_id' => 'Unit',
            'unit_price' => 'Unit Price',
            'shelf_life' => 'Shelf Life',
            'hour_used' => 'Hour Used',
            'time_used' => 'Time Used',
            'expiration_date' => 'Expiration Date',
            'status' => 'Status',
            'received' => 'Received',
            'created' => 'Created',
            'last_cali' => 'Last Calibration',
            'next_cali' => 'Next Calibration',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
            'deleted' => 'Deleted',
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
    public function getPart()
    {
        return $this->hasOne(Part::className(), ['id' => 'part_id']);
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

    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }


    public static function dataTool(){
        return ArrayHelper::map(Tool::find()->where(['<>','status','deleted'])->andWhere(['<>','status','inactive'])->all(), 'id', 'part_id');
    }

    public static function getTool($id=null) {
        if ( $id === null ) {
            $tool = Tool::find()->where(['<>','status','inactive'])->all();
            return $tool;
        }
        $tool = Tool::find()->where(['id' => $id])->one();
        return $tool;
    }

    public static function getToolGroupByPart() {
        $tool = Tool::find()
        ->select(['*,SUM(quantity) AS qty'])
        ->where(['<>','status','inactive'])
        ->andWhere(['<>','in_used',1])
        ->groupBy(['part_id'])
        ->all();
        return $tool;
    }
    public static function getToolGroupByPartWo($woId) {
        $tool = Tool::find()
        ->select(['*,SUM(quantity) AS qty'])
        ->where(['<>','status','inactive'])
        ->andWhere(['in_used' => 1])
        ->andWhere(['work_order_id' => $woId])
        ->groupBy(['part_id'])
        ->all();
        return $tool;
    }


    public static function getToolByWoPart($woId,$partId,$returnAmount) {
        $tool = false;
        if ( $returnAmount > 0 ) {
            $tool = Tool::find()
            ->where(['work_order_id' => $woId])
            ->andWhere(['part_id' => $partId])
            ->limit($returnAmount)
            ->all();
        }
        return $tool;
    }
    /*  
        tool out function 
        get stock id and return in array 
        there will be multiple stock_id
    */
    public static function stockOut($partId,$quantitySelected) {
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

                /* AB :: update stock quantity */
                $updateStock = Stock::find()->where(['id' => $stockId])->one();
                $updateStock->quantity = $stockQuantity;
                $updateStock->save();
                $data['stock_quantity'][] = $stockQuantity;

            }
        }
        
        return $data;
    }


    public function getNextCalibration() {
        $today = date('Y-m-d');
        $fiveDaysBeforeToday = date('Y-m-d',(strtotime ( '+5 day' , strtotime ( $today) ) ) );
        $Tool = Tool::find()
                            ->where(['>=', 'next_cali', $today])
                            ->andWhere(['<=', 'next_cali', $fiveDaysBeforeToday])
                            ->all();
        return $Tool;
    }
}
