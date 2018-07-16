<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tool_po_payment".
 *
 * @property integer $id
 * @property integer $tool_po_id
 * @property string $amount
 * @property string $time_paid
 * @property integer $paid_by
 * @property string $remark
 * @property integer $status
 */
class ToolPoPayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tool_po_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tool_po_id', 'paid_by', 'status'], 'integer'],
            [['amount'], 'number'],
            [['time_paid'], 'safe'],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tool_po_id' => 'Purchase Order ID',
            'amount' => 'Amount',
            'time_paid' => 'Time Paid',
            'paid_by' => 'Paid By',
            'remark' => 'Remark',
            'status' => 'Status',
        ];
    }
}
