<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gpo_supplier".
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
 * @property string $approval_status
 * @property string $status
 * @property integer $created_by
 * @property string $created
 * @property integer $updated_by
 * @property string $updated
 * @property integer $deleted
 */
class TpoSupplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gpo_supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p_currency', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['survey_date', 'created', 'updated'], 'safe'],
            [['status'], 'string'],
            [['company_name', 'scope_of_approval'], 'string', 'max' => 100],
            [['addr', 'p_addr_1', 'p_addr_2', 'p_addr_3'], 'string', 'max' => 500],
            [['contact_person', 'title', 'approval_status'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 255],
            [['contact_no', 'scope_of_approval'], 'string', 'max' => 20],
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
            'approval_status' => 'Approval Status',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created' => 'Created',
            'updated_by' => 'Updated By',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
        ];
    }
}
