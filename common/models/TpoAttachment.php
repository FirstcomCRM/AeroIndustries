<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tpo_attachment".
 *
 * @property integer $id
 * @property integer $tool_po_id
 * @property string $type
 * @property string $value
 * @property string $remark
 */
class TpoAttachment extends \yii\db\ActiveRecord
{
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tpo_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tool_po_id'], 'integer'],
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
            'tool_po_id' => 'Tool Po ID',
            'type' => 'Type',
            'value' => 'Value',
            'remark' => 'Remark',
        ];
    }
    /* id = work order id */
    public static function getTpoAttachment($id=null) {
        if ( $id === null ) {
            return TpoAttachment::find()
            ->all();
        }
        return TpoAttachment::find()
        ->where(['tool_po_id' => $id])
        ->all();
    }
}
