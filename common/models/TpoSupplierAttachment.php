<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tpo_supplier_attachment".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property string $value
 * @property string $remark
 */
class TpoSupplierAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $attachment;

    public static function tableName()
    {
        return 'tpo_supplier_attachment';
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
