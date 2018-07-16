<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "traveler_log".
 *
 * @property integer $id
 * @property string $description
 * @property string $date
 * @property string $revision_no
 * @property string $created
 * @property integer $created_by
 */
class TravelerLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'traveler_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['date', 'created'], 'safe'],
            [['created_by','traveler_id'], 'integer'],
            [['revision_no'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'date' => 'Date',
            'revision_no' => 'Revision No',
            'created' => 'Created',
            'created_by' => 'Created By',
        ];
    }
    public static function getTravelerLog($id=null) {
        $TravelerLog = TravelerLog::find()->where(['traveler_id' => $id])->orderBy('id DESC')->all();
        return $TravelerLog;
    }
    public static function getLatestTravelerLog($id=null) {
        $TravelerLog = TravelerLog::find()->where(['traveler_id' => $id])->orderBy('id DESC')->one();
        return $TravelerLog;
    }
}
