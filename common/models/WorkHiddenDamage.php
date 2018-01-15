<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "work_hidden_damage".
 *
 * @property integer $id
 * @property integer $work_order_id
 * @property string $discrepancy
 * @property string $corrective
 * @property string $repair_supervisor
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 */
class WorkHiddenDamage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_hidden_damage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_order_id', 'created_by', 'updated_by','work_order_part_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['discrepancy', 'corrective'], 'string'],
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
            'discrepancy' => 'Discrepancy',
            'corrective' => 'Corrective',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
        ];
    }
    /* id = work order id */
    public static function getWorkHiddenDamage($id=null,$work_order_part_id) {
        return WorkHiddenDamage::find()->where(['work_order_id' => $id])->andWhere(['work_order_part_id' => $work_order_part_id])->all();
    }
}
