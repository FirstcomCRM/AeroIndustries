<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "uphostery_part_used".
 *
 * @property integer $id
 * @property integer $uphostery_id
 * @property string $remark
 * @property integer $stock_id
 * @property integer $qty
 * @property integer $st_qty
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $update_by
 */
class UphosteryPartUsed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uphostery_part_used';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uphostery_id', 'stock_id','tool_id','part_id','created_by', 'update_by'], 'integer'],
            [['qty', 'st_qty','qty_used'],'number'],
            [['created', 'updated'], 'safe'],
            [['uphostery_id'],'required'],
            [['remark'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uphostery_id' => 'Uphostery',
            'remark' => 'Remark',
            'stock_id' => 'Stock',
            'part_id' => 'Part',
            'qty' => 'Quantity',
            'st_qty' => 'Stock Quantity',
            'qty_used' => 'Quantity Used',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'update_by' => 'Update By',
        ];
    }
    public function getStock()
    {
        return $this->hasOne(Stock::className(), ['id' => 'stock_id']);
    }


    /* id = uphostery order id */
    public static function getUphosteryPartUsed($id=null) {
        if ( $id === null ) {
            return UphosteryPartUsed::find()->all();
        }
        return UphosteryPartUsed::find()->where(['uphostery_id' => $id])->all();
    }
    /* id = uphostery order id */
    public static function getOneUphosteryPartUsed($id=null) {
        return UphosteryPartUsed::find()->where(['id' => $id])->one();
    }
}
