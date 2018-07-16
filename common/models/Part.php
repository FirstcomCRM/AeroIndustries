<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "part".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $supplier_id
 * @property string $part_no
 * @property string $desc
 * @property string $storage_area
 * @property string $batch_no
 * @property string $note
 * @property integer $quantity
 * @property string $unit_price
 * @property string $expire_on
 * @property integer $status
 * @property string $created
 * @property string $updated
 */
class Part extends \yii\db\ActiveRecord
{
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'part';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'created_by', 'updated_by','deleted','unit_id','reusable','is_shelf_life','supplier_id'], 'integer'],
            [['created', 'updated', 'status','type','restock'], 'safe'],
            [['part_no', 'default_unit_price','manufacturer'], 'string', 'max' => 45],
            [['desc'], 'string', 'max' => 255],
            [['attachment'], 'file', 'maxFiles' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'category_id' => 'Category ID',
            'supplier_id' => 'Supplier',
            'part_no' => 'Part No',
            'desc' => 'Desc',
            'storage_area' => 'Storage Area',
            'batch_no' => 'Batch No',
            'note' => 'Note',
            'quantity' => 'Quantity',
            'default_unit_price' => 'Unit Price',
            'expire_on' => 'Expire On',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
            'restock' => 'Re-order Level',
            'is_shelf_life' => 'Shelf Life',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(PartCategory::className(), ['id' => 'category_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }
    public static function dataPart($id=null) {
        return ArrayHelper::map(Part::find()->where(['status'=>'active'])->all(), 'id', 'part_no');
    }
    public static function dataPartStock($supplier_id=null) {
        if ( !empty( $supplier_id ) ){
            $parts = Part::find()
                    ->where(['status'=>'active'])
                    ->andWhere(['type' => 'part'])
                    ->andWhere(['supplier_id' => $supplier_id])
                    ->all();
                    if($parts){
                        return ArrayHelper::map($parts, 'id', 'part_no');
                    }
            return [];

        }
        return [];
    }
    public static function dataToolStock($supplier_id=null) {
        if ( !empty( $supplier_id ) ){
            $parts = Part::find()
                    ->where(['status'=>'active'])
                    ->andWhere(['type' => 'tool'])
                    ->andWhere(['supplier_id' => $supplier_id])
                    ->all();
                    if($parts){
                        return ArrayHelper::map($parts, 'id', 'part_no');
                    }
            return [];

        }
        return [];
    }
    public static function dataPartTool($id=null) {
        return ArrayHelper::map(Part::find()->where(['status'=>'active'])->andWhere(['type' => 'tool'])->all(), 'id', 'part_no');
    }
    public static function dataPartType($id=null) {
        return ArrayHelper::map(Part::find()->where(['status'=>'active'])->all(), 'id', 'type');
    }
    public static function dataPartDesc($id=null) {
        return ArrayHelper::map(Part::find()->where(['status'=>'active'])->all(), 'id', 'desc');
    }
    public static function dataPartUnit($id=null) {
        return ArrayHelper::map(Part::find()->where(['status'=>'active'])->all(), 'id', 'unit_id');
    }
    public static function dataPartReusable($id=null) {
        return ArrayHelper::map(Part::find()->where(['status'=>'active'])->all(), 'id', 'reusable');
    }
    public static function dataPartShelf($id=null) {
        return ArrayHelper::map(Part::find()->where(['status'=>'active'])->all(), 'id', 'is_shelf_life');
    }

    public static function getPart($id=null) {
        if ( $id === null ) {
            return Part::find()->all();
        }
        return Part::find()->where(['id' => $id])->one();
    }

    public static function getPartType($type=null) {
        return Part::find()->andWhere(['type' => $type])->all();
    }

    public static function checkReusable($partId=null) {
        $part = Part::find()->andWhere(['id' => $partId])->one();
        return $part->reusable;
    }

}
