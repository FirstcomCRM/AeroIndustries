<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "uphostery_preliminary".
 *
 * @property integer $id
 * @property integer $uphostery_id
 * @property string $discrepancy
 * @property string $corrective
 */
class UphosteryPreliminary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uphostery_preliminary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uphostery_id','uphostery_part_id'], 'integer'],
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
            'uphostery_id' => 'Uphostery ID',
            'discrepancy' => 'Discrepancy',
            'corrective' => 'Corrective',
        ];
    }
    /* id = uphostery order id */
    public static function getUphosteryPreliminary($id=null,$uphostery_part_id) {
        return UphosteryPreliminary::find()->where(['uphostery_id' => $id])->andWhere(['uphostery_part_id' => $uphostery_part_id])->all();
    }
}
