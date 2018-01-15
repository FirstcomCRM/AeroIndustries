<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rfq".
 *
 * @property integer $id
 * @property string $date
 * @property integer $supplier_id
 * @property string $quotation_no
 * @property string $value
 * @property string $remark
 * @property integer $deleted
 */
class Rfq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rfq';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date','created','updated'], 'safe'],
            [['supplier_id', 'deleted','created_by', 'updated_by'], 'integer'],
            [['remark','manufacturer','trace_certs'], 'string'],
            [['date'], 'required'],
            [['quotation_no'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'supplier_id' => 'Supplier',
            'quotation_no' => 'Quotation No',
            'remark' => 'Remark',
            'deleted' => 'Deleted',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }
}
