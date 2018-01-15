<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quotation".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $reference
 * @property string $type
 * @property string $date
 * @property integer $lead_time
 * @property string $attention
 * @property string $p_term
 * @property integer $p_currency
 * @property string $d_term
 * @property string $work_performed
 * @property string $subtotal
 * @property integer $subj_gst
 * @property string $grand_total
 * @property string $remark
 * @property string $status
 * @property string $created
 * @property string $updated
 */
class Quotation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_no','customer_id', 'p_currency','created_by', 'updated_by','status','deleted','work_order_id','quotation_no'], 'integer'],
            [['date', 'created', 'updated','approved','certification'], 'safe'],
            [['subtotal', 'grand_total','gst_rate'], 'number'],
            [['reference', 'attention', 'p_term', 'lead_time', 'd_term','customer_po'], 'string', 'max' => 45],
            [['remark'], 'string', 'max' => 500],
            [['address'], 'string', 'max' => 255],
            [['date','work_order_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'reference' => 'Reference',
            'date' => 'Date',
            'lead_time' => 'Lead Time',
            'address' => 'Address',
            'attention' => 'Attention',
            'p_term' => 'P Term',
            'p_currency' => 'P Currency',
            'd_term' => 'D Term',
            'subtotal' => 'Subtotal',
            'gst_rate' => 'GST',
            'customer_po' => 'Customer Order No',
            'grand_total' => 'Grand Total',
            'remark' => 'Remark',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
            'work_order_id' => 'Work Order No',
        ];
    }

    public function getCustomer(){
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getCurrency(){
        return $this->hasOne(Currency::className(), ['id' => 'p_currency']);
    }
    public static function getQuotation($id=null)
    {
        if ( $id === null ) {
            $Quotation = Quotation::find()->where(['deleted' => '0'])->all();
            return $Quotation;
        }
        $Quotation = Quotation::find()->where(['id' => $id])->andWhere(['deleted' => '0'])->one();
        return $Quotation;
    }
}
