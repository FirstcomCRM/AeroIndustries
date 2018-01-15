<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase_order_payment".
 *
 * @property integer $id
 * @property integer $purchase_order_id
 * @property string $amount
 * @property string $time_paid
 * @property integer $paid_by
 * @property string $remark
 * @property integer $status
 */
class PurchaseOrderPayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_order_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_order_id', 'paid_by', 'status'], 'integer'],
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
            'purchase_order_id' => 'Purchase Order ID',
            'amount' => 'Amount',
            'time_paid' => 'Time Paid',
            'paid_by' => 'Paid By',
            'remark' => 'Remark',
            'status' => 'Status',
        ];
    }
}
