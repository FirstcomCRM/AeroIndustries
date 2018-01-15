<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "traveler_content".
 *
 * @property integer $id
 * @property integer $traveler_id
 * @property string $content
 */
class TravelerContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'traveler_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['traveler_id','sort'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'traveler_id' => 'Traveler ID',
        ];
    }
    
    public function getTravelerContentTId($id=null)
    {
        if ( $id === null ) {
            $TravelerContent = TravelerContent::find()->all();
            return $TravelerContent;
        }
        $TravelerContent = TravelerContent::find()->where(['traveler_id' => $id])->all();
        return $TravelerContent;
    }
    
    public function getTravelerContent($id=null)
    {
        if ( $id === null ) {
            $TravelerContent = TravelerContent::find()->all();
            return $TravelerContent;
        }
        $TravelerContent = TravelerContent::find()->where(['id' => $id])->one();
        return $TravelerContent;
    }
    
    public function deleteAllContent($traveler_id=null)
    {
        return TravelerContent::deleteAll(['traveler_id' => $traveler_id]);
    }
}
