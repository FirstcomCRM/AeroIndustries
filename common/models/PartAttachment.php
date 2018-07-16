<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "part_attachment".
 *
 * @property integer $id
 * @property integer $part_id
 * @property string $file_name
 * @property string $file_path
 */
class PartAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $attachment;

    public static function tableName()
    {
        return 'part_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['part_id', 'file_name', 'file_path'], 'required'],
            [['part_id'], 'integer'],
            [['file_path','file_name'], 'string'],
              [['attachment'], 'file', 'maxFiles' => 10,'extensions' => 'png, jpg',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'part_id' => 'Part ID',
            'file_name' => 'File Name',
            'file_path' => 'File Path',
            'attachment'=>'Attachment',
        ];
    }
}
