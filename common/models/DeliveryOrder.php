<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "delivery_order".
 *
 * @property integer $id
 * @property string $delivery_order_no
 * @property string $po_number
 * @property string $date
 * @property integer $customer_id
 * @property string $ship_to
 * @property string $contact_no
 * @property string $remark
 * @property string $status
 * @property string $created
 * @property integer $created_by
 */
class DeliveryOrder extends \yii\db\ActiveRecord
{
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'created','address','sco_no','delivery_order_no','value'], 'safe'],
            [['customer_id', 'created_by' ,'is_attachment','deleted'], 'integer'],
            [['ship_to'], 'string', 'max' => 500],
            [['contact_no'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 12],
            [['date'], 'required'],
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
            'sco_no' => 'SCO No.',
            'delivery_order_no' => 'Delivery Order No.',
            'date' => 'Date',
            'is_attachment' => 'Attachment',
            'customer_id' => 'Customer',
            'ship_to' => 'Ship To',
            'contact_no' => 'Contact No.',
            'status' => 'Status',
            'created' => 'Created',
            'created_by' => 'Created By',
        ];
    }
    public function getCustomer(){
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
