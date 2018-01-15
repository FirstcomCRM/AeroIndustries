<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "work_order_attachment".
 *
 * @property integer $id
 * @property integer $work_order_id
 * @property string $value
 */
class WorkOrderAttachment extends \yii\db\ActiveRecord
{
    /* for upload */
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_order_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_order_id','work_order_part_id'], 'integer'],
            [['type'], 'safe'],
            [['value'], 'string', 'max' => 255],
            [['attachment'], 'file', 'maxFiles' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'work_order_id' => 'Work Order ID',
            'value' => 'Value',
        ];
    }
    /* id = work order id */
    public static function getWorkOrderAttachmentW($id=null,$work_order_part_id) {
        if ( $id === null ) {
            return WorkOrderAttachment::find()
            ->all();
        }
        return WorkOrderAttachment::find()
        ->where(['work_order_id' => $id])
        ->andWhere(['work_order_part_id' => $work_order_part_id])
        ->andWhere(['type' => 'work_order'])
        ->all();
    }
    /* id = work order id */
    public static function getWorkOrderAttachmentP($id=null,$work_order_part_id) {
        if ( $id === null ) {
            return WorkOrderAttachment::find()
            ->all();
        }
        return WorkOrderAttachment::find()
        ->where(['work_order_id' => $id])
        ->andWhere(['work_order_part_id' => $work_order_part_id])
        ->andWhere(['type' => 'preliminary_inspection'])
        ->all();
    }
    /* id = work order id */
    public static function getWorkOrderAttachmentD($id=null,$work_order_part_id) {
        if ( $id === null ) {
            return WorkOrderAttachment::find()
            ->all();
        }
        return WorkOrderAttachment::find()
        ->where(['work_order_id' => $id])
        ->andWhere(['work_order_part_id' => $work_order_part_id])
        ->andWhere(['type' => 'disposition'])
        ->all();
    }
    /* id = work order id */
    public static function getWorkOrderAttachmentF($id=null,$work_order_part_id) {
        if ( $id === null ) {
            return WorkOrderAttachment::find()
            ->all();
        }
        return WorkOrderAttachment::find()
        ->where(['work_order_id' => $id])
        ->andWhere(['work_order_part_id' => $work_order_part_id])
        ->andWhere(['type' => 'final'])
        ->all();
    }
    /* id = work order id */
    public static function getWorkOrderAttachmentH($id=null,$work_order_part_id) {
        $hidden_damage = WorkHiddenDamage::find()
        ->where(['work_order_id'=>$id])
        ->andWhere(['work_order_part_id' => $work_order_part_id])
        ->one();
        if ( $hidden_damage )  { 
            $hidden_damage_id = $hidden_damage
            ->id;

            return WorkOrderAttachment::find()
            ->where(['work_order_id' => $id])
            ->andWhere(['work_order_part_id' => $work_order_part_id])
            ->andWhere(['type' => 'hidden_damage'])
            ->all();
        }
        return array();
    }
    /* id = work order id */
    public static function getWorkOrderAttachmentS($id=null,$work_order_part_id) {
        return 
        WorkOrderAttachment::find()
        ->where(['work_order_id' => $id])
        ->andWhere(['work_order_part_id' => $work_order_part_id])
        ->andWhere(['type' => 'traveler'])
        ->all();
    }
    /* id = work order id */
    public static function getWorkOrderAttachmentPI($id=null,$work_order_part_id) {
        if ( $id === null ) {
            return WorkOrderAttachment::find()
            ->all();
        }
        return WorkOrderAttachment::find()
        ->where(['work_order_id' => $id])
        ->andWhere(['work_order_part_id' => $work_order_part_id])
        ->andWhere(['type' => 'processing_inspection'])
        ->all();
    }
}
