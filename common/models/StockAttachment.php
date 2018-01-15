<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_attachment".
 *
 * @property integer $id
 * @property integer $stock_id
 * @property string $type
 * @property string $value
 * @property string $remark
 */
class StockAttachment extends \yii\db\ActiveRecord
{
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stock_id'], 'integer'],
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
            'stock_id' => 'Stock ID',
            'type' => 'Type',
            'value' => 'Value',
            'remark' => 'Remark',
        ];
    }
}
