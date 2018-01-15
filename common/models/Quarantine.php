<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quarantine".
 *
 * @property integer $id
 * @property integer $part_id
 * @property integer $work_order_id
 * @property string $serial_no
 * @property string $batch_no
 * @property string $lot_no
 * @property string $desc
 * @property integer $quantity
 * @property string $reason
 * @property string $date
 * @property integer $status
 * @property string $created
 * @property string $updated
 */
class Quarantine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quarantine';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'work_order_id', 'quantity', 'status','created_by','updated_by'], 'integer'],
            [['date', 'created', 'updated'], 'safe'],
            [['part_no','serial_no', 'batch_no', 'lot_no'], 'string', 'max' => 45],
            [['desc', 'reason'], 'string', 'max' => 1000],
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
            'work_order_id' => 'Work Order No',
            'serial_no' => 'Serial No',
            'batch_no' => 'Batch No',
            'lot_no' => 'Lot No',
            'desc' => 'Desc',
            'quantity' => 'Quantity',
            'reason' => 'Reason',
            'date' => 'Date',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    public function getWorkOrder(){
        return $this->hasOne(WorkOrder::className(), ['id' => 'work_order_id']);
    }

    public static function checkQuarantine($work_order_id = null){
        $quarantine = Quarantine::find()->where(['work_order_id' => $work_order_id])->one();
        if ( $quarantine ) {
            return $quarantine;
        } else {
            return false;
        }
    }
}
