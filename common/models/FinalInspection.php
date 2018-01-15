<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "final_inspection".
 *
 * @property integer $id
 * @property integer $build_no
 * @property string $title
 * @property string $content
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 */
class FinalInspection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'final_inspection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['build','form_no'], 'string', 'max' => 45],
            [['content'], 'string', 'max' => 5000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'build' => 'Build No',
            'title' => 'Title',
            'content' => 'Content',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
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
}
