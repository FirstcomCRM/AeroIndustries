<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "staff".
 *
 * @property integer $id
 * @property string $name
 * @property string $staff_no
 * @property string $department
 * @property string $date_joined
 * @property string $title
 * @property integer $group_id
 * @property string $stamp
 * @property string $auth_no
 * @property integer $status
 * @property string $created
 * @property string $updated
 */
class Staff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_joined', 'created', 'updated', 'status'], 'safe'],
            [['group_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['staff_no', 'title', 'auth_no'], 'string', 'max' => 45],
            [['department'], 'string', 'max' => 50],
            [['stamp'], 'string', 'max' => 15],
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
            'staff_no' => 'Staff No',
            'department' => 'Department',
            'date_joined' => 'Date Joined',
            'title' => 'Title',
            'group_id' => 'Group',
            'stamp' => 'Stamp',
            'auth_no' => 'Auth No',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    public static function dataStaffId($id=null) {
        return ArrayHelper::map(Staff::find()->where(['<>','status','inactive'])->all(), 'id', 'name');
    }


    public static function dataStaff($id=null) {
        return ArrayHelper::map(Staff::find()->where(['<>','status','inactive'])->all(), 'name', 'name');
    }

    public static function dataStaffTechnician($id=null) {
        return ArrayHelper::map(Staff::find()->where(['<>','status','inactive'])->andWhere(['group_id' => 5])->all(), 'name', 'name');
    }
}
