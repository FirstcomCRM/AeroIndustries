<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "traveler_sub".
 *
 * @property integer $id
 * @property integer $traveler_content_id
 * @property string $content
 * @property integer $sort
 */
class TravelerSub extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'traveler_sub';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['traveler_content_id', 'sort'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'traveler_content_id' => 'Traveler Content ID',
            'content' => 'Content',
            'sort' => 'Sort',
        ];
    }

    public static function getTravelerSub($contentId) {
        $TravelerSub = TravelerSub::find()->where(['traveler_content_id' => $contentId])->all();
        return $TravelerSub;
    }
}
