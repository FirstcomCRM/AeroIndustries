<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $address_type
 * @property string $address
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 * @property string $status
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'created_by', 'updated_by'], 'integer'],
            [['address_type', 'address', 'status'], 'string'],
            [['created', 'updated'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'address_type' => 'Address Type',
            'address' => 'Address',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public static function getAddresses($customer_id) {
        $addr = Address::find()->where(['customer_id' => $customer_id])->andWhere(['status' => 'active'])->all();
        return $addr;
    }
}
