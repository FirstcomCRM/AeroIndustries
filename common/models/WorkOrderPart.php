<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "work_order_part".
 *
 * @property integer $id
 * @property string $part_no
 * @property string $desc
 * @property string $manufacturer
 * @property string $model
 * @property string $serial_no
 * @property string $batch_no
 * @property string $new_part_no
 * @property integer $traveler_id
 * @property integer $template_id
 * @property string $arc_status
 * @property string $arc_remarks
 * @property integer $repair_supervisor
 * @property string $preliminary_date
 * @property string $disposition_date
 * @property string $hidden_date
 * @property string $final_inspection_date
 * @property string $ac_tail_no
 * @property string $ac_msn
 * @property integer $is_document
 * @property integer $is_tag
 * @property integer $is_id
 * @property string $tag_type
 * @property integer $is_discrepancy
 * @property string $identify_from
 * @property string $part_no_1
 * @property string $part_no_2
 * @property string $part_no_3
 * @property string $corrective
 * @property string $remarks
 * @property string $updated
 * @property string $created
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $status
 * @property integer $deleted
 */
class WorkOrderPart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_order_part';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desc', 'corrective', 'remarks','man_hour','productive_hour'], 'string'],
            [['traveler_id', 'template_id', 'is_document', 'is_tag', 'is_id', 'is_discrepancy','work_order_id', 'created_by', 'updated_by', 'deleted','location_id','quantity','is_processing','is_receiving','is_preliminary','is_hidden','is_traveler','is_final'], 'integer'],
            [['preliminary_date', 'disposition_date', 'hidden_date', 'final_inspection_date', 'repair_supervisor', 'updated', 'created'], 'safe'],
            [['part_no', 'model', 'serial_no', 'batch_no', 'new_part_no'], 'string', 'max' => 50],
            [['manufacturer', 'ac_tail_no', 'ac_msn', 'tag_type', 'identify_from', 'part_no_1', 'part_no_2', 'part_no_3', 'status','pma_used'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'part_no' => 'Part No',
            'is_receiving' => 'Receiving Inspection',
            'is_preliminary' => 'Preliminary Inspection',
            'is_hidden' => 'Hidden Inspection',
            'is_traveler' => 'Worksheet',
            'is_final' => 'Final Inspection',
            'productive_hour' => 'Prod. Hour',
            'desc' => 'Desc',
            'manufacturer' => 'Manufacturer',
            'model' => 'Model',
            'serial_no' => 'Serial No',
            'batch_no' => 'Batch No',
            'new_part_no' => 'New Part No',
            'traveler_id' => 'Traveler ID',
            'template_id' => 'Template ID',
            'arc_status' => 'ARC Status',
            'arc_remarks' => 'ARC Remarks',
            'repair_supervisor' => 'Repair Supervisor',
            'preliminary_date' => 'Preliminary Date',
            'disposition_date' => 'Disposition Date',
            'hidden_date' => 'Hidden Date',
            'final_inspection_date' => 'Final Inspection Date',
            'ac_tail_no' => 'AC Tail No',
            'ac_msn' => 'AC MSN',
            'location_id' => 'Location',
            
            'updated' => 'Updated',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'deleted' => 'Deleted',

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
            'pma_used' => 'PMA Used',
        ];
    }

    public static function getWorkOrderPart($workOrderId) {
        $WorkOrderPart = WorkOrderPart::find()->where(['work_order_id' => $workOrderId])->andWhere(['deleted' => '0'])->all();
        return $WorkOrderPart;
    }

    public static function saveWo($workOrderParts,$workOrderId) {
        // dx($workOrderParts);
        $part_nos = $workOrderParts['part_no'];
        $postData = Yii::$app->request->post();
        foreach ( $part_nos as $key => $part_no ){
            if ( $key !=0 ) {
                if ( isset( $postData['WorkOrderPart']['id'][$key] ) ) {
                    $oldWOP = WorkOrderPart::getWorkOrderPartById($postData['WorkOrderPart']['id'][$key]);
                    $oldWOP->work_order_id = $workOrderId;
                    $oldWOP->part_no = $part_no;
                    $oldWOP->desc = $workOrderParts['desc'][$key];
                    $oldWOP->manufacturer = $workOrderParts['manufacturer'][$key];
                    $oldWOP->model = $workOrderParts['model'][$key];
                    $oldWOP->ac_tail_no = $workOrderParts['ac_tail_no'][$key];
                    $oldWOP->ac_msn = $workOrderParts['ac_msn'][$key];
                    $oldWOP->serial_no = $workOrderParts['serial_no'][$key];
                    $oldWOP->batch_no = $workOrderParts['batch_no'][$key];
                    $oldWOP->location_id = $workOrderParts['location_id'][$key];
                    $oldWOP->batch_no = $workOrderParts['batch_no'][$key];
                    $oldWOP->template_id = isset($workOrderParts['template_id'][$key-1])?$workOrderParts['template_id'][$key-1]:0;
                    $oldWOP->quantity = $workOrderParts['quantity'][$key];
                    $oldWOP->deleted = $workOrderParts['deleted'][$key];
                    $oldWOP->man_hour = $workOrderParts['man_hour'][$key];
                    $oldWOP->productive_hour = $workOrderParts['productive_hour'][$key];
                    $oldWOP->new_part_no = $workOrderParts['new_part_no'][$key];
                    $oldWOP->save();
                } else {
                    $newWOP = new WorkOrderPart();
                    $newWOP->work_order_id = $workOrderId;
                    $newWOP->part_no = $part_no;
                    $newWOP->desc = $workOrderParts['desc'][$key];
                    $newWOP->manufacturer = $workOrderParts['manufacturer'][$key];
                    $newWOP->model = $workOrderParts['model'][$key];
                    $newWOP->ac_tail_no = $workOrderParts['ac_tail_no'][$key];
                    $newWOP->ac_msn = $workOrderParts['ac_msn'][$key];
                    $newWOP->serial_no = $workOrderParts['serial_no'][$key];
                    $newWOP->batch_no = $workOrderParts['batch_no'][$key];
                    $newWOP->location_id = $workOrderParts['location_id'][$key];
                    $newWOP->batch_no = $workOrderParts['batch_no'][$key];
                    $newWOP->template_id = isset($workOrderParts['template_id'][$key-1])?$workOrderParts['template_id'][$key-1]:0;
                    $newWOP->quantity = $workOrderParts['quantity'][$key];
                    $newWOP->save();
                }
            }
        }
    }


    public static function getWorkOrderPartById($work_order_part_id) {
        $WorkOrderPart = WorkOrderPart::find()->where(['id' => $work_order_part_id])->andWhere(['deleted' => '0'])->one();
        return $WorkOrderPart;
    }
}
