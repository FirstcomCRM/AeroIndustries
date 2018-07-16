<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "work_order".
 *
 * @property integer $id
 * @property integer $work_order_no
 * @property integer $customer_id
 * @property string $customer_po_no
 * @property string $date
 * @property string $received_date
 * @property string $serial_no
 * @property string $part_no
 * @property string $work_type
 * @property integer $work_order_id
 * @property integer $template_id
 * @property integer $quantity
 * @property string $desc
 * @property string $remark
 * @property string $qc_notes
 * @property string $inspection
 * @property string $corrective
 * @property string $disposition_note
 * @property string $hidden_damage
 * @property string $arc_remark
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 * @property string $status
 * @property integer $deleted
 */
class WorkOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_order';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_order_no', 'customer_id', 'created_by', 'updated_by', 'deleted','is_do','delivery_order_id'], 'integer'],
            [['date', 'received_date', 'created', 'updated', 'on_dock_date', 'needs_by_date','approval_date'], 'safe'],
            [['work_type', 'status','work_scope', 'qc_notes', 'complaint','remark'], 'string'],
            [['customer_po_no'], 'string', 'max' => 25],
            [['date', 'status'], 'required'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_receiving' => 'Receiving Inspection',
            'is_preliminary' => 'Preliminary Inspection',
            'is_hidden' => 'Hidden Inspection',
            'is_traveler' => 'Worksheet',
            'is_final' => 'Final Inspection',
            'work_order_no' => 'Work Order No',
            'customer_id' => 'Customer',
            'customer_po_no' => 'Customer Po No',
            'date' => 'Work Order Creation Date',
            'received_date' => 'Received Date',
            'on_dock_date' => 'TAT Date',
            
            'new_part_no' => 'Part No Changed',
            'batch_no' => 'Batch No',
            'work_type' => 'Product Type',
            'template_id' => 'Template',
            'quantity' => 'Quantity',
            'desc' => 'Description',
            // 'remark' => 'Remark',
            'qc_notes' => 'Remarks',
            'arc_remark' => 'ARC Remark',
            'arc_status' => 'ARC Status',
            'traveler_id' => 'Traveler',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'Manufacturer' => 'Manufacturer',
            'model' => 'Eligibility',
            'ac_tail_no' => 'A/C Tail No',
            'ac_msn' => 'A/C MSN',
            'work_scope' => 'Job Type',
            'complaint' => 'Reasons for removal',
            'pma_used' => 'PMA Part Used',
            'needs_by_date' => 'Estimated Delivery Date',
            'location_id' => 'Location',
            'preliminary_date' => 'Date',
            'hidden_date' => 'Date',

            'is_document' => 'Customer\'s Documents',
            'is_tag' => 'Customer\'s Tag',
            'is_id' => 'Identification(ID) Tag',
            'tag_type' => 'ID Tag Type',
            'is_discrepancy' => 'Discrepancy with Customer\'s Documents',
            'identify_from' => 'Identification of Part Number From',

            'part_no_1' => 'Part Number (as written in Customer\'s Documents)',
            'part_no_2' => 'Part Number (as written in Customer Tag)',
            'part_no_3' => 'Part Number (as written in Identification Tag)',
            'corrective' => 'Corrective action on discrepancy',
            'remarks' => 'Remarks',

            'arc_status' => 'ARC Status',
            'traveler_id' => 'Traveler',
        ];
    }
    public function getCustomer(){
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
    public function getAttachment(){
        return $this->hasMany(WorkOrderAttachment::className(), ['work_order_id' => 'id']);
    }
    public function getWorkHiddenDamage(){
        return $this->hasOne(WorkHiddenDamage::className(), ['id' => 'work_order_id']);
    }
    public static function dataWorkScope() {
        return ArrayHelper::map(WorkOrder::find()->where(['<>','deleted','1'])->all(), 'id', 'work_scope');
    }
    public static function dataWorkType() {
        return ArrayHelper::map(WorkOrder::find()->where(['<>','deleted','1'])->all(), 'id', 'work_type');
    }
    public static function dataWorkOrder() {
        return ArrayHelper::map(WorkOrder::find()->where(['<>','deleted','1'])->orderBy(['id' => SORT_DESC])->all(), 'id', 'work_order_no');
    }
    public static function getWorkOrder($id=null)
    {
        if ( $id === null ) {
            $WorkOrder = WorkOrder::find()->where(['deleted' => '0'])->all();
            return $WorkOrder;
        }
        $WorkOrder = WorkOrder::find()->where(['id' => $id])->andWhere(['deleted' => '0'])->one();
        return $WorkOrder;
    }
    public static function getWorkOrderInProgress($id=null)
    {
        if ( $id === null ) {
            $WorkOrder = WorkOrder::find()->where(['deleted' => '0'])->andWhere(['<>','status','completed'])->all();
            return $WorkOrder;
        }
        $WorkOrder = WorkOrder::find()->where(['id' => $id])->andWhere(['deleted' => '0'])->one();
        return $WorkOrder;
    }
    public static function getWorkOrderCompleted($id=null)
    {
        if ( $id === null ) {
            $WorkOrder = WorkOrder::find()->where(['deleted' => '0'])->andWhere(['status' => 'completed'])->all();
            return $WorkOrder;
        }
        $WorkOrder = WorkOrder::find()->where(['id' => $id])->andWhere(['deleted' => '0'])->one();
        return $WorkOrder;
    }
    public static function saveWo($mo) {
        $mo->work_order_no = 1;
        $wwo = WorkOrder::find()->where(['<>','deleted', 1])->orderBy('work_order_no DESC')->limit(1)->one();
        if ( !empty ( $wwo ) ) {
            $previousNo = $wwo->work_order_no;
            $mo->work_order_no = $previousNo + 1;
        }
        $mo->created_by = Yii::$app->user->identity->id;
        $currentDateTime = date("Y-m-d H:i:s");
        $mo->created = $currentDateTime;
        $mo->save();
        $workOrderId = $mo->id;
        return $workOrderId;
    }   
    public static function saveStockUsed($requisition,$work_order_id,$work_order_part_id) {
        $partIds = Yii::$app->request->post()['PartId'];
        foreach ( $partIds as $key => $partId ) {
            $quantitySelected = $requisition->qty_required[$key];
            $checkStock = Stock::checkStock($partId,$quantitySelected);
            $stockIds = $checkStock['stock_id'];
            $quantity_useds = $checkStock['quantity_used'];
            $quantity_in_stock = $checkStock['stock_quantity'];
            foreach ($stockIds as $key2 => $stockId ) {
                $newWPU = new WorkStockRequisition();
                $newWPU->work_order_id = $work_order_id;
                $newWPU->work_order_part_id = $work_order_part_id;
                $newWPU->stock_id = $stockId;
                $newWPU->part_id = $partId;
                $newWPU->qty_required = $quantity_useds[$key2];
                $newWPU->uom = $requisition->uom[$key];
                $newWPU->qty_stock = $quantity_in_stock[$key2];
                $newWPU->remark = $requisition->remark[$key];
                $newWPU->created_by = Yii::$app->user->identity->id;
                $currentDateTime = date("Y-m-d H:i:s");
                $newWPU->created = $currentDateTime;
                $newWPU->save();
            } /* foreach stock id used */
        } /* foreach Part id */
    }
    public static function saveStockIssued($requisition,$work_order_id,$work_order_part_id) {
        $stockIds = $requisition['stock_id'];
        $workOrder = WorkOrder::getWorkOrder($work_order_id);
        $workOrderNo = '';
        if ( $workOrder->work_scope && $workOrder->work_type ) {
            $workOrderNo = Setting::getWorkNo($workOrder->work_type,$workOrder->work_scope,$workOrder->work_order_no);
        }
        foreach ( $stockIds as $key => $stock_id ) {
            $partId = $requisition['part_id'][$key];
            $quantityIssue = $requisition['issue_qty'][$key];
            $issuedDate = $requisition['issued_date'][$key];
            $issuedTime = $requisition['issued_time'][$key];
            $issuedTime = $issuedDate . ' ' . $issuedTime;
            // if(Part::checkReusable($partId) == 1) {
            //     $stockOut = Stock::stockOutByStockId($stock_id,$quantityIssue);
            // } else {
                $stockOut = Stock::stockOutByPartId($partId,$quantityIssue);
            // }
            if ( !empty( $stockOut ) ) {
                $getWSR = WorkStockRequisition::getWSR($requisition['stock_id'][$key],$work_order_id,$work_order_part_id);
                $getWSR->issued_time = $issuedTime;
                $getWSR->qty_issued = $requisition['qty_issued'][$key] + $requisition['issue_qty'][$key];
                $getWSR->issued_by = $requisition['issued_by'][$key];
                $getWSR->issued_to = $requisition['issued_to'][$key];
                $getWSR->qty_stock = $stockOut['stock_quantity'][0];
                $getWSR->status = 'issued';
                $getWSR->save();
                $text = 'Stock issue';
                Stock::updateStockHistory($partId,$workOrderNo,$requisition['issue_qty'][$key],$text);

            }
        } /* foreach Part id */
    } 
    public static function saveStockReturned($requisition,$work_order_id,$work_order_part_id) {
        $partIds = $requisition['part_id'];
        $workOrder = WorkOrder::getWorkOrder($work_order_id);
        $workOrderNo = '';
        if ( $workOrder->work_scope && $workOrder->work_type ) {
            $workOrderNo = Setting::getWorkNo($workOrder->work_type,$workOrder->work_scope,$workOrder->work_order_no);
        }
        foreach ( $partIds as $key => $part_id ) {
            $partId = $requisition['part_id'][$key];
            /* get stock */
            $stock_id = $requisition['stock_id'][$key];
            $qty_returned = $requisition['qty_returned'][$key];
            $returned_date = $requisition['returned_date'][$key];
            $returned_time = $requisition['returned_time'][$key];
            $hour_used = $requisition['hour_used'][$key];
            $returned_time = $returned_date . ' ' . $returned_time;
            $newStockQty = Stock::stockReturn($stock_id,$qty_returned,$hour_used);
            // d($requisition);exit;
            if ( !empty( $newStockQty ) ) {
                $getWSR = WorkStockRequisition::getWSR($requisition['stock_id'][$key],$work_order_id,$work_order_part_id);
                $getWSR->returned_time = $returned_time;
                $getWSR->qty_returned = $requisition['qty_returned'][$key] + $requisition['return_qty'][$key] ;
                $getWSR->hour_used = $hour_used;
                $getWSR->returned_by = $requisition['returned_by'][$key];
                $getWSR->returned_to = $requisition['returned_to'][$key];
                $getWSR->qty_stock = $newStockQty;
                $getWSR->status = 'closed';
                $getWSR->save();
                $text = 'Stock return';
                Stock::updateStockHistory($partId,$workOrderNo,$requisition['return_qty'][$key],$text);
                Stock::stockReturn($stock_id,$requisition['return_qty'][$key],$hour_used);
            }
        } /* foreach Part id */
    } 
}
