<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase_order_attachment".
 *
 * @property integer $id
 * @property integer $purchase_order_id
 * @property string $type
 * @property string $value
 * @property string $remark
 */
class PurchaseOrderAttachment extends \yii\db\ActiveRecord
{
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_order_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_order_id'], 'integer'],
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
            'purchase_order_id' => 'Purchase Order',
            'type' => 'Type',
            'value' => 'Value',
            'remark' => 'Remark',
        ];
    }
    /* id = work order id */
    public static function getPurchaseOrderAttachment($id=null) {
        if ( $id === null ) {
            return PurchaseOrderAttachment::find()
            ->all();
        }
        return PurchaseOrderAttachment::find()
        ->where(['purchase_order_id' => $id])
        ->all();
    }
}
