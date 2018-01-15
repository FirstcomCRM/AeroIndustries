<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quotation_attachment".
 *
 * @property integer $id
 * @property integer $quotation_id
 * @property string $type
 * @property string $value
 * @property string $remark
 */
class QuotationAttachment extends \yii\db\ActiveRecord
{
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_id'], 'integer'],
            [['type', 'remark'], 'string', 'max' => 45],
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
            'quotation_id' => 'Quotation ID',
            'type' => 'Type',
            'value' => 'Value',
            'remark' => 'Remark',
        ];
    }
}
