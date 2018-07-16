<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "work_order_arc".
 *
 * @property integer $id
 * @property integer $work_order_id
 * @property string $date
 * @property string $type
 * @property integer $first_check
 * @property integer $second_check
 * @property integer $form_tracking_no
 */
class WorkOrderArc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_order_arc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_order_id', 'work_order_part_id', 'first_check', 'second_check', 'third_check', 'forth_check','is_tracking_no','form_tracking_no'], 'integer'],
            [['date','name','arc_status','arc_remarks'], 'safe'],
            [['type'], 'string'],
            [['date', 'type'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'work_order_id' => 'Work Order No.',
            'is_tracking_no' => 'Add Tracking No.',
            'date' => 'Date',
            'type' => 'Type',
            'first_check' => 'Release to Service',
            'second_check' => 'Other regulation specified',
            'third_check' => ' Approved design data and are in condition for safe operation',
            'forth_check' => 'Non-approved design data specified in Block 13',
            'form_tracking_no' => 'Form Tracking No',
        ];
    }
    /* id = work order id */
    public static function getWorkOrderArc($id=null,$work_order_part_id) {
        if ( $id === null ) {
            return WorkOrderArc::find()->all();
        }
        return WorkOrderArc::find()->where(['work_order_id' => $id])->andWhere(['work_order_part_id'=>$work_order_part_id])->all();
    }
    public function getWorkOrder(){
        return $this->hasOne(WorkOrder::className(), ['id' => 'work_order_id']);
    }
}
