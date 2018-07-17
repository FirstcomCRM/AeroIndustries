<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "uphostery_hidden_damage".
 *
 * @property integer $id
 * @property integer $uphostery_id
 * @property string $discrepancy
 * @property string $corrective
 * @property string $repair_supervisor
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 */
class UphosteryHiddenDamage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uphostery_hidden_damage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uphostery_id', 'created_by', 'updated_by','uphostery_part_id'], 'integer'],
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
            'uphostery_id' => 'Upholstery ID',
            'discrepancy' => 'Discrepancy',
            'corrective' => 'Corrective',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
        ];
    }
    /* id = uphostery order id */
    public static function getUphosteryHiddenDamage($id=null,$uphostery_part_id) {
        return UphosteryHiddenDamage::find()->where(['uphostery_id' => $id])->andWhere(['uphostery_part_id' => $uphostery_part_id])->all();
    }
}
