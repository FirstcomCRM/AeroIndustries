<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "work_preliminary".
 *
 * @property integer $id
 * @property integer $work_order_id
 * @property string $discrepancy
 * @property string $corrective
 */
class WorkPreliminary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_preliminary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_order_id','work_order_part_id'], 'integer'],
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
        ];
    }
    /* id = work order id */
    public static function getWorkPreliminary($id=null,$work_order_part_id) {
        return WorkPreliminary::find()->where(['work_order_id' => $id])->andWhere(['work_order_part_id' => $work_order_part_id])->all();
    }
}
