<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "delivery_order_detail".
 *
 * @property integer $id
 * @property integer $delivery_order_id
 * @property integer $work_order_no
 * @property integer $part_no
 * @property string $desc
 * @property integer $quantity
 * @property string $remark
 */
class DeliveryOrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery_order_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_order_id', 'quantity'], 'integer'],
            [['desc'], 'string', 'max' => 45],
            [['part_no', 'work_order_no', 'remark'],'safe'],
            [['po_no'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_order_id' => 'Delivery Order',
            'work_order_no' => 'Work Order',
            'po_no' => 'PO Number',
            'part_no' => 'Part No',
            'desc' => 'Desc',
            'quantity' => 'Quantity',
            'remark' => 'Remark',
        ];
    }
}
