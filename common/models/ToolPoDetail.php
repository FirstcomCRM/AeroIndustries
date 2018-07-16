<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tool_po_detail".
 *
 * @property integer $id
 * @property integer $tool_po_id
 * @property integer $part_id
 * @property integer $quantity
 * @property string $unit_price
 * @property integer $unit_id
 * @property string $freight
 * @property string $subtotal
 * @property integer $received
 */
class ToolPoDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tool_po_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tool_po_id', 'part_id', 'quantity', 'unit_id', 'received'], 'integer'],
            [['unit_price', 'freight', 'subtotal'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tool_po_id' => 'Tool Po ID',
            'part_id' => 'Part ID',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'unit_id' => 'Unit ID',
            'freight' => 'Freight',
            'subtotal' => 'Subtotal',
            'received' => 'Received',
        ];
    }
    public static function getToolPoDetail($id=null) {
        if ( $id === null ) {
            return ToolPoDetail::find()->all();
        }
        return ToolPoDetail::find()->where(['tool_po_id' => $id])->all();
    }
}
