<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "calibration_attachment".
 *
 * @property integer $id
 * @property integer $calibration_id
 * @property string $value
 */
class CalibrationAttachment extends \yii\db\ActiveRecord
{
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calibration_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calibration_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['attachment'], 'file', 'maxFiles' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'calibration_id' => 'Calibration ID',
            'value' => 'Value',
        ];
    }
    public static function getCalibrationAttachment($calibration_id) {
        return CalibrationAttachment::find()->where(['calibration_id' => $calibration_id])->all();
    }
}
