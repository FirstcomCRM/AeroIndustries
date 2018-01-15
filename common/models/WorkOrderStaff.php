<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "work_order_staff".
 *
 * @property integer $id
 * @property integer $work_order_id
 * @property integer $staff_type
 * @property string $staff_name
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 */
class WorkOrderStaff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_order_staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_order_id', 'created_by', 'updated_by'], 'integer'],
            [['created', 'updated','staff_type'], 'safe'],
            [['staff_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'work_order_id' => 'Work Order ID',
            'staff_type' => 'Staff Type',
            'staff_name' => 'Staff Name',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
        ];
    }
    public static function getFinalInspector($workOrderId) {
        return WorkOrderStaff::find()->where(['work_order_id' => $workOrderId])->andWhere(['staff_type' => 'final inspector'])->one();
    }
    public static function getSupervisor($workOrderId) {
        return WorkOrderStaff::find()->where(['work_order_id' => $workOrderId])->andWhere(['staff_type' => 'supervisor'])->one();
    }
    public static function getTechnician($workOrderId) {
        return WorkOrderStaff::find()->where(['work_order_id' => $workOrderId])->andWhere(['staff_type' => 'technician'])->all();
    }
    public static function getInspector($workOrderId) {
        return WorkOrderStaff::find()->where(['work_order_id' => $workOrderId])->andWhere(['staff_type' => 'inspector'])->all();
    }
}
