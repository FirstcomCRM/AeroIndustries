<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "supplier_quarantine".
 *
 * @property integer $id
 * @property string $stock_id
 * @property integer $quantity
 * @property string $reason
 * @property string $date
 * @property integer $status
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 */
class SupplierQuarantine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier_quarantine';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['date', 'created', 'updated'], 'safe'],
            [['stock_id'], 'string', 'max' => 45],
            [['reason'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stock_id' => 'Stock ID',
            'quantity' => 'Quantity',
            'reason' => 'Reason',
            'date' => 'Date',
            'status' => 'Status',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
        ];
    }
    public function getStock(){
        return $this->hasOne(Stock::className(), ['id' => 'stock_id']);
    }
}
