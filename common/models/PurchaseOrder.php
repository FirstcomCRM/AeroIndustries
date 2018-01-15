<?php

namespace common\models;

use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "purchase_order".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property string $supplier_ref_no
 * @property string $purchase_order_no
 * @property string $issue_date
 * @property string $delivery_date
 * @property string $p_term
 * @property integer $p_currency
 * @property string $ship_via
 * @property string $ship_to
 * @property string $subtotal
 * @property integer $subj_gst
 * @property string $grand_total
 * @property string $remark
 * @property integer $clone
 * @property string $created
 * @property string $updated
 */
class PurchaseOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_order_no','supplier_id', 'p_currency', 'q_currency', 'clone','created_by','updated_by','status','deleted'], 'integer'],
            [['issue_date', 'delivery_date', 'created', 'updated','approved','authorized_by'], 'safe'],
            [['subtotal', 'grand_total','gst_rate', 'conversion', 'usd_total'], 'number'],
            [['supplier_ref_no'], 'string', 'max' => 20],
            [['p_term', 'ship_via','attention'], 'string', 'max' => 45],
            [['ship_to'], 'string', 'max' => 500],
            [['remark','payment_addr'], 'string', 'max' => 255],
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
            'supplier_id' => 'Supplier ID',
            'supplier_ref_no' => 'Ref No',
            'purchase_order_no' => 'Purchase Order No',
            'issue_date' => 'PO Date',
            'delivery_date' => 'Delivery Date',
            'p_term' => 'Payment Term',
            'p_currency' => 'PO Currency',
            'q_currency' => 'Quotation Currency',
            'ship_via' => 'Ship Via',
            'ship_to' => 'Ship To',
            'subtotal' => 'Subtotal',
            'attention' => 'Attention',
            'grand_total' => 'Grand Total',
            'remark' => 'Remark',
            'clone' => 'Clone',
            'conversion' => 'Conversion',
            'usd_total' => 'USD Total',
            'payment_addr' => 'Supplier Address',
            'created' => 'Created',
            'updated' => 'Updated',
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

    public static function getPurchaseOrder($id=null) {
        if ( $id === null ) {
            return PurchaseOrder::find()->all();
        }
        return PurchaseOrder::find()->where(['id' => $id])->one();
    }

    public static function dataPO() {
        return ArrayHelper::map(PurchaseOrder::find()->where(['<>','deleted',1])->andWhere(['approved'=>'approved'])->orderBy('id DESC')->all(), 'id', 'purchase_order_no');
    }

    
    public static function getPONo($purchase_order_no,$created) {
        $ymdHis = explode(' ',$created);
        $yyyymmdd = explode('-', $ymdHis[0]);
        $yyyy = $yyyymmdd[0];
        $yy = substr($yyyy, 2, 2);
        $yymm = $yy.$yyyymmdd[1];
        $poNumber = "AIS-PO$yymm" . sprintf("%003d", $purchase_order_no);
        return $poNumber;
    }
    
    public static function getPONoById($purchase_order_id) {
        $gasd = PurchaseOrder::getPurchaseOrder($purchase_order_id);
        $created = $gasd->created;
        $purchase_order_no = $gasd->purchase_order_no;
        $ymdHis = explode(' ',$created);
        $yyyymmdd = explode('-', $ymdHis[0]);
        $yyyy = $yyyymmdd[0];
        $yy = substr($yyyy, 2, 2);
        $yymm = $yy.$yyyymmdd[1];
        $poNumber = "AIS-PO$yymm" . sprintf("%003d", $purchase_order_no);
        return $poNumber;
    }
    public static function dataAllPO() {
        return ArrayHelper::map(PurchaseOrder::find()->where(['<>','deleted',1])->andWhere(['<>','approved','cancelled'])->orderBy('id DESC')->all(), 'id', 'purchase_order_no');
    }
    public static function dataAllPOCreated() {
        return ArrayHelper::map(PurchaseOrder::find()->where(['<>','deleted',1])->andWhere(['<>','approved','cancelled'])->orderBy('id DESC')->all(), 'id', 'created');
    }

}
