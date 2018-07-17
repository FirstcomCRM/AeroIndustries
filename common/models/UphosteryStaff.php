<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "uphostery_staff".
 *
 * @property integer $id
 * @property integer $uphostery_id
 * @property integer $staff_type
 * @property string $staff_name
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 */
class UphosteryStaff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uphostery_staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uphostery_id', 'created_by', 'updated_by'], 'integer'],
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
            'uphostery_id' => 'Upholstery ID',
            'staff_type' => 'Staff Type',
            'staff_name' => 'Staff Name',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
        ];
    }
    public static function getFinalInspector($uphosteryId) {
        return UphosteryStaff::find()->where(['uphostery_id' => $uphosteryId])->andWhere(['staff_type' => 'final inspector'])->one();
    }
    public static function getSupervisor($uphosteryId) {
        return UphosteryStaff::find()->where(['uphostery_id' => $uphosteryId])->andWhere(['staff_type' => 'supervisor'])->one();
    }
    public static function getTechnician($uphosteryId) {
        return UphosteryStaff::find()->where(['uphostery_id' => $uphosteryId])->andWhere(['staff_type' => 'technician'])->all();
    }
    public static function getInspector($uphosteryId) {
        return UphosteryStaff::find()->where(['uphostery_id' => $uphosteryId])->andWhere(['staff_type' => 'inspector'])->all();
    }
}
