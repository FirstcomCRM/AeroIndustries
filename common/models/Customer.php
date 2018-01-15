<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $name
 * @property string $addr_1
 * @property string $addr_2
 * @property string $contact_person
 * @property string $email
 * @property string $contact_no
 * @property string $title
 * @property string $s_addr_1
 * @property string $s_addr_2
 * @property string $b_addr_1
 * @property string $b_addr_2
 * @property string $b_term
 * @property integer $b_currency
 * @property string $status
 * @property string $created
 * @property string $updated
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['b_currency','created_by','updated_by','deleted'], 'integer'],
            [['created', 'updated', 'status'], 'safe'],
            [['name', 'email'], 'string', 'max' => 255],
            [['freight_forwarder', 'company_name'], 'string', 'max' => 100],
            [['addr_1', 'addr_2', 's_addr_1', 's_addr_2', 'b_addr_1', 'b_addr_2'], 'string', 'max' => 500],
            [['contact_person','contact'], 'string', 'max' => 45],
            [['contact_no', 'b_term'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'addr_1' => 'Addr 1',
            'addr_2' => 'Addr 2',
            'contact_person' => 'Contact Person',
            'email' => 'Email',
            'contact_no' => 'Contact No',
            'title' => 'Title',
            's_addr_1' => 'S Addr 1',
            's_addr_2' => 'S Addr 2',
            'b_addr_1' => 'B Addr 1',
            'b_addr_2' => 'B Addr 2',
            'b_term' => 'B Term',
            'b_currency' => 'B Currency',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    public static function getCustomer($id=null) {
        if ( $id === null ) {
            $customer = Customer::find()->where(['<>','status','inactive'])->all();
            return $customer;
        }
        $customer = Customer::find()->where(['id' => $id])->andWhere(['<>','status','inactive'])->one();
        return $customer;
    }

    public static function dataCustomer($id=null) {
        return ArrayHelper::map(Customer::find()->where(['status' => 'active'])->where(['deleted' => '0'])->all(), 'id', 'name');
    }
}
