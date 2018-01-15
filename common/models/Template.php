<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "template".
 *
 * @property integer $id
 * @property string $part_no
 * @property string $desc
 * @property string $remark
 * @property string $insert
 * @property integer $location_id
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 */
class Template extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location_id', 'created_by', 'updated_by'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['part_no'], 'string', 'max' => 45],
            [['desc', 'remark'], 'string', 'max' => 100],
            [['alternative'], 'string', 'max' => 500],
            [['insert'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'part_no' => 'Part No',
            'desc' => 'Description',
            'remark' => 'Remark',
            'insert' => 'Insert',
            'location_id' => 'Location',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'alternative' => 'Alternate P/N',
            'updated_by' => 'Udpated By',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by'])->from(['created_by' => User::tableName()]);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by'])->from(['updated_by' => User::tableName()]);
    }

    public static function dataTemplate(){
        return ArrayHelper::map(Template::find()->where(['<>','deleted','1'])->all(), 'id', 'part_no');
    }
}
