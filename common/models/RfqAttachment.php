<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rfq_attachment".
 *
 * @property integer $id
 * @property integer $rfq_id
 * @property string $value
 */
class RfqAttachment extends \yii\db\ActiveRecord
{
    /* for upload */
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rfq_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'rfq_id'], 'integer'],
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
            'rfq_id' => 'Rfq ID',
            'value' => 'Value',
        ];
    }

    public static function getRfqAttachment($id = null) {
        if ( $id === null ) {
            return RfqAttachment::find()->all();
        }
        return RfqAttachment::find()->where(['rfq_id' => $id ])->all();
    }
}
