<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase_order_detail".
 *
 * @property integer $id
 * @property integer $purchase_order_id
 * @property integer $part_id
 * @property integer $quantity
 * @property string $unit_price
 * @property string $freight
 * @property string $subtotal
 * @property string $conversion
 * @property string $usd_subtotal
 * @property integer $received
 */
class PurchaseOrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_order_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_order_id', 'part_id', 'quantity', 'received', 'unit_id'], 'integer'],
            [['unit_price','subtotal'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_order_id' => 'Purchase Order ID',
            'part_id' => 'Part ID',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'unit_id' => 'UM',
            'subtotal' => 'Subtotal',
            'received' => 'Received',
        ];
    }
    public static function getPurchaseOrderDetail($id=null) {
        if ( $id === null ) {
            return PurchaseOrderDetail::find()->all();
        }
        return PurchaseOrderDetail::find()->where(['purchase_order_id' => $id])->all();
    }
}
