<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "supplier_attachment".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property string $value
 * @property string $remark
 */
class SupplierAttachment extends \yii\db\ActiveRecord
{

    /* for upload */
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id'], 'integer'],
            [['value', 'remark'], 'string', 'max' => 255],
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
            'supplier_id' => 'Supplier ID',
            'value' => 'Value',
            'remark' => 'Remark',
        ];
    }
}
