<?php

namespace common\models;

use Yii;

use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "supplier".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $addr
 * @property string $contact_person
 * @property string $email
 * @property string $contact_no
 * @property string $title
 * @property string $p_addr_1
 * @property string $p_addr_2
 * @property string $p_addr_3
 * @property integer $p_currency
 * @property string $scope_of_approval
 * @property string $survey_date
 * @property integer $status
 * @property string $created
 * @property string $updated
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p_currency', 'created_by', 'updated_by'], 'integer'],
            [['survey_date', 'status','created', 'updated','approval_status'], 'safe'],
            [['company_name'], 'string', 'max' => 100],
            [['addr', 'p_addr_1', 'p_addr_2', 'p_addr_3'], 'string', 'max' => 500],
            [['contact_person'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 255],
            [['contact_no', 'scope_of_approval'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'addr' => 'Addr',
            'contact_person' => 'Contact Person',
            'email' => 'Email',
            'contact_no' => 'Contact No',
            'title' => 'Title',
            'p_addr_1' => 'P Addr 1',
            'p_addr_2' => 'P Addr 2',
            'p_addr_3' => 'P Addr 3',
            'p_currency' => 'P Currency',
            'scope_of_approval' => 'Scope Of Approval',
            'survey_date' => 'Survey Date',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
    public static function dataSupplier($id=null) {
        return ArrayHelper::map(Supplier::find()->where(['<>','status','inactive'])->all(), 'id', 'company_name');
    }

    public static function getSupplier($id=null) {
        if ( $id === null ) {
            return Supplier::find()->all();
        }
        return Supplier::find()->where(['id' => $id])->one();
    }
}
