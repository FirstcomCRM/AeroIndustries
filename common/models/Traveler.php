<?php

namespace common\models;

use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "traveler".
 *
 * @property integer $id
 * @property string $traveler_no
 * @property string $job_type
 * @property string $desc
 * @property string $effectivity
 * @property integer $revision_no
 * @property string $revision_date
 * @property string $discont_reason
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 * @property string $status
 * @property string $value
 */
class Traveler extends \yii\db\ActiveRecord
{
    /* for upload */
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'traveler';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['revision_no', 'created_by', 'updated_by'], 'integer'],
            [['revision_date', 'created', 'updated'], 'safe'],
            [['status', 'value'], 'string'],
            [['traveler_no'], 'string', 'max' => 15],
            [['job_type'], 'string', 'max' => 12],
            [['desc'], 'string', 'max' => 100],
            [['effectivity'], 'string', 'max' => 20],
            [['discont_reason'], 'string', 'max' => 500],
            [['attachment'], 'file', 'maxFiles' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'traveler_no' => 'Worksheet No',
            'job_type' => 'Job Type',
            'desc' => 'Desc',
            'effectivity' => 'Effectivity',
            'revision_no' => 'Revision No',
            'revision_date' => 'Revision Date',
            'discont_reason' => 'Discont Reason',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'value' => 'Attachment',
        ];
    }
    public static function dataTraveler(){
        return ArrayHelper::map(Traveler::find()->where(['<>','status','deleted'])->andWhere(['<>','status','inactive'])->all(), 'id', 'traveler_no');
    }
}
