<?php

namespace common\models;

use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "general_po".
 *
 * @property integer $id
 * @property integer $purchase_order_no
 * @property integer $supplier_id
 * @property string $attention
 * @property string $supplier_ref_no
 * @property string $payment_addr
 * @property string $issue_date
 * @property string $delivery_date
 * @property string $p_term
 * @property integer $p_currency
 * @property string $ship_via
 * @property string $ship_to
 * @property string $subtotal
 * @property string $gst_rate
 * @property string $grand_total
 * @property string $usd_total
 * @property string $conversion
 * @property string $remark
 * @property integer $clone
 * @property integer $status
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 * @property string $approved
 * @property integer $deleted
 */
class GeneralPo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'general_po';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_order_no', 'supplier_id', 'p_currency', 'clone', 'status', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['issue_date', 'delivery_date', 'created', 'updated','authorized_by'], 'safe'],
            [['subtotal', 'gst_rate', 'grand_total', 'usd_total', 'conversion'], 'number'],
            [['approved'], 'string'],
            [['attention', 'p_term', 'ship_via'], 'string', 'max' => 45],
            [['supplier_ref_no'], 'string', 'max' => 20],
            [['payment_addr', 'remark'], 'string', 'max' => 255],
            [['ship_to'], 'string', 'max' => 500],
            [['issue_date','delivery_date'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_order_no' => 'Purchase Order No',
            'supplier_id' => 'Supplier',
            'attention' => 'Attention',
            'supplier_ref_no' => 'Supplier Ref No',
            'payment_addr' => 'Payment Addr',
            'issue_date' => 'Issue Date',
            'delivery_date' => 'Delivery Date',
            'p_term' => 'Payment Term',
            'p_currency' => 'Payment Currency',
            'ship_via' => 'Ship Via',
            'ship_to' => 'Ship To',
            'subtotal' => 'Subtotal',
            'gst_rate' => 'Gst Rate',
            'grand_total' => 'Grand Total',
            'usd_total' => 'USD Total',
            'conversion' => 'Conversion',
            'remark' => 'Remark',
            'clone' => 'Clone',
            'status' => 'Status',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
            'approved' => 'Approved',
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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'p_currency']);
    }
    public static function getGeneralPo($id=null) {
        if ( $id === null ) {
            return GeneralPo::find()->all();
        }
        return GeneralPo::find()->where(['id' => $id])->one();
    }

    public static function getGPONo($purchase_order_no,$created) {
        $ymdHis = explode(' ',$created);
        $yyyymmdd = explode('-', $ymdHis[0]);
        $yyyy = $yyyymmdd[0];
        $yy = substr($yyyy, 2, 2);
        $yymm = $yy.$yyyymmdd[1];
        $poNumber = "AIS-GPO$yymm" . sprintf("%003d", $purchase_order_no);
        return $poNumber;
    }
    public static function getGPONoById($purchase_order_id) {
        $gasd = GeneralPo::getGeneralPo($purchase_order_id);
        $created = $gasd->created;
        $purchase_order_no = $gasd->purchase_order_no;
        $ymdHis = explode(' ',$created);
        $yyyymmdd = explode('-', $ymdHis[0]);
        $yyyy = $yyyymmdd[0];
        $yy = substr($yyyy, 2, 2);
        $yymm = $yy.$yyyymmdd[1];
        $poNumber = "AIS-GPO$yymm" . sprintf("%003d", $purchase_order_no);
        return $poNumber;
    }
    public static function dataGPO() {
        return ArrayHelper::map(GeneralPo::find()->where(['<>','deleted',1])->andWhere(['approved'=>'approved'])->orderBy('id DESC')->all(), 'id', 'purchase_order_no');
    }
    public static function dataAllGPO() {
        return ArrayHelper::map(GeneralPo::find()->where(['<>','deleted',1])->andWhere(['<>','approved','cancelled'])->orderBy('id DESC')->all(), 'id', 'purchase_order_no');
    }
    public static function dataAllGPOCreated() {
        return ArrayHelper::map(GeneralPo::find()->where(['<>','deleted',1])->andWhere(['<>','approved','cancelled'])->orderBy('id DESC')->all(), 'id', 'created');
    }


}   
