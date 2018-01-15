<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "scrap".
 *
 * @property integer $id
 * @property integer $work_order_id
 * @property string $part_no
 * @property string $description
 * @property string $serial_no
 * @property string $date
 * @property string $remark
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 * @property integer $deleted
 */
class Scrap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scrap';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_order_id','work_order_part_id', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['date', 'created', 'updated'], 'safe'],
            [['part_no', 'serial_no','batch_no'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 255],
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
            'work_order_part_id'=>'Work Part ID',
            'part_no' => 'Part No',
            'description' => 'Description',
            'serial_no' => 'Serial No',
            'date' => 'Date',
            'remark' => 'Remark',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
            'deleted' => 'Deleted',
        ];
    }

    public function getWorkOrder(){
        return $this->hasOne(WorkOrder::className(), ['id' => 'work_order_id']);
    }
    public static function checkScrap($work_order_id = null){
        $scrap = Scrap::find()->where(['work_order_id' => $work_order_id])->one();
        if ( $scrap ) {
            return $scrap;
        } else {
            return false;
        }
    }
}
