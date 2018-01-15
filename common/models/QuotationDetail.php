<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quotation_detail".
 *
 * @property integer $id
 * @property integer $quotation_id
 * @property integer $group
 * @property string $service_details
 * @property string $work_type
 * @property integer $quantity
 * @property string $unit_price
 * @property string $subtotal
 * @property string $remark
 */
class QuotationDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_id', 'group', 'quantity'], 'integer'],
            [['unit_price', 'subtotal'], 'number'],
            [['service_details', 'remark'], 'string', 'max' => 255],
            [['work_type'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_id' => 'Quotation ID',
            'group' => 'Group',
            'service_details' => 'Service Details',
            'work_type' => 'Work Type',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'subtotal' => 'Subtotal',
            'remark' => 'Remark',
        ];
    }
}
