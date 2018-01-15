<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "uphostery_stock_requisition".
 *
 * @property integer $id
 * @property integer $uphostery_id
 * @property string $remark
 * @property integer $part_id
 * @property integer $stock_id
 * @property double $qty_required
 * @property double $qty_stock
 * @property double $qty_used
 * @property integer $qty_issued
 * @property integer $issued_by
 * @property integer $issued_to
 * @property string $issued_time
 * @property double $qty_returned
 * @property integer $returned_by
 * @property integer $returned_to
 * @property string $returned_time
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $update_by
 * @property string $status
 */
class UphosteryStockRequisition extends \yii\db\ActiveRecord
{
    public $issue_qty;
    public $issued_date;
    public $returned_date;
    public $return_qty;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uphostery_stock_requisition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uphostery_id', 'uphostery_part_id', 'part_id', 'stock_id', 'qty_issued', 'issued_by', 'issued_to', 'returned_by', 'returned_to', 'created_by', 'update_by'], 'integer'],
            [['remark', 'status','uom'], 'string'],
            [['qty_required', 'qty_stock', 'qty_used', 'qty_returned','hour_used'], 'number'],
            [['issued_time', 'returned_time', 'created', 'updated','issue_qty', 'issued_date','returned_date','return_qty'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uphostery_id' => 'Uphostery',
            'uphostery_part_id' => 'Uphostery Part',
            'remark' => 'Remark',
            'part_id' => 'Part ID',
            'stock_id' => 'Stock ID',
            'qty_required' => 'Qty Required',
            'qty_stock' => 'Qty Stock',
            'qty_used' => 'Qty Used',
            'qty_issued' => 'Qty Issued',
            'issued_by' => 'Issued By',
            'issued_to' => 'Issued To',
            'issued_time' => 'Issued Time',
            'qty_returned' => 'Qty Returned',
            'returned_by' => 'Returned By',
            'returned_to' => 'Returned To',
            'returned_time' => 'Returned Time',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'update_by' => 'Update By',
            'status' => 'Status',
        ];
    }
    public function getStock(){
        return $this->hasOne(Stock::className(), ['id' => 'stock_id']);
    }

    public static function getWSRByUphosteryId($workOrderId) {
        return UphosteryStockRequisition::find()->where(['uphostery_id' => $workOrderId])->all();
    }

    public static function getWSRByUphosteryPartId($workOrderPartId) {
        return UphosteryStockRequisition::find()->where(['uphostery_part_id' => $workOrderPartId])->all();
    }

    public static function getWSR($stockId, $workOrderId,$workOrderPartId) {
        return UphosteryStockRequisition::find()->where(['uphostery_id' => $workOrderId,'stock_id' => $stockId,'uphostery_part_id' => $workOrderPartId])->one();
    }
    public static function getWSRbyId($WSRID) {
        return UphosteryStockRequisition::find()->where(['id' => $WSRID])->one();
    }
}
