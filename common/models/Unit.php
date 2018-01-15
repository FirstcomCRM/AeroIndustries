<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property integer $id
 * @property string $name
 * @property string $unit
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 * @property integer $deleted
 * @property string $status
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'updated'], 'safe'],
            [['created_by', 'updated_by', 'deleted'], 'integer'],
            [['status'], 'string'],
            [['name'], 'string', 'max' => 45],
            [['unit'], 'string', 'max' => 5],
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
            'unit' => 'Unit',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
            'deleted' => 'Deleted',
            'status' => 'Status',
        ];
    }

    

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by'])->from(['created_by' => User::tableName()]);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by'])->from(['updated_by' => User::tableName()]);
    }

    public static function dataUnit()
    {
        return ArrayHelper::map(Unit::find()->where(['status'=>'active'])->all(), 'id', 'unit');
    }
}
