<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "work_part_used".
 *
 * @property integer $id
 * @property integer $work_order_id
 * @property string $remark
 * @property integer $stock_id
 * @property integer $qty
 * @property integer $st_qty
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $update_by
 */
class WorkPartUsed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_part_used';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_order_id', 'stock_id','tool_id','part_id','created_by', 'update_by'], 'integer'],
            [['qty', 'st_qty','qty_used'],'number'],
            [['created', 'updated'], 'safe'],
            [['work_order_id'],'required'],
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
            'work_order_id' => 'Work Order',
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


    /* id = work order id */
    public static function getWorkPartUsed($id=null) {
        if ( $id === null ) {
            return WorkPartUsed::find()->all();
        }
        return WorkPartUsed::find()->where(['work_order_id' => $id])->all();
    }
    /* id = work order id */
    public static function getOneWorkPartUsed($id=null) {
        return WorkPartUsed::find()->where(['id' => $id])->one();
    }
}
