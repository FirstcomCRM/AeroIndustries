<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "uphostery_attachment".
 *
 * @property integer $id
 * @property integer $uphostery_id
 * @property string $value
 */
class UphosteryAttachment extends \yii\db\ActiveRecord
{
    /* for upload */
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uphostery_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uphostery_id','uphostery_part_id'], 'integer'],
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
            'uphostery_id' => 'Uphostery ID',
            'value' => 'Value',
        ];
    }
    /* id = uphostery id */
    public static function getUphosteryAttachmentW($id=null,$uphostery_part_id) {
        if ( $id === null ) {
            return UphosteryAttachment::find()
            ->all();
        }
        return UphosteryAttachment::find()
        ->where(['uphostery_id' => $id])
        ->andWhere(['uphostery_part_id' => $uphostery_part_id])
        ->andWhere(['type' => 'uphostery'])
        ->all();
    }
    /* id = uphostery id */
    public static function getUphosteryAttachmentP($id=null,$uphostery_part_id) {
        if ( $id === null ) {
            return UphosteryAttachment::find()
            ->all();
        }
        return UphosteryAttachment::find()
        ->where(['uphostery_id' => $id])
        ->andWhere(['uphostery_part_id' => $uphostery_part_id])
        ->andWhere(['type' => 'preliminary_inspection'])
        ->all();
    }
    /* id = uphostery id */
    public static function getUphosteryAttachmentD($id=null,$uphostery_part_id) {
        if ( $id === null ) {
            return UphosteryAttachment::find()
            ->all();
        }
        return UphosteryAttachment::find()
        ->where(['uphostery_id' => $id])
        ->andWhere(['uphostery_part_id' => $uphostery_part_id])
        ->andWhere(['type' => 'disposition'])
        ->all();
    }
    /* id = uphostery id */
    public static function getUphosteryAttachmentF($id=null,$uphostery_part_id) {
        if ( $id === null ) {
            return UphosteryAttachment::find()
            ->all();
        }
        return UphosteryAttachment::find()
        ->where(['uphostery_id' => $id])
        ->andWhere(['uphostery_part_id' => $uphostery_part_id])
        ->andWhere(['type' => 'final'])
        ->all();
    }
    /* id = uphostery id */
    public static function getUphosteryAttachmentH($id=null,$uphostery_part_id) {
        $hidden_damage = UphosteryHiddenDamage::find()
        ->where(['uphostery_id'=>$id])
        ->andWhere(['uphostery_part_id' => $uphostery_part_id])
        ->one();
        if ( $hidden_damage )  { 
            $hidden_damage_id = $hidden_damage
            ->id;

            return UphosteryAttachment::find()
            ->where(['uphostery_id' => $id])
            ->andWhere(['uphostery_part_id' => $uphostery_part_id])
            ->andWhere(['type' => 'hidden_damage'])
            ->all();
        }
        return array();
    }
    /* id = uphostery id */
    public static function getUphosteryAttachmentS($id=null,$uphostery_part_id) {
        return 
        UphosteryAttachment::find()
        ->where(['uphostery_id' => $id])
        ->andWhere(['uphostery_part_id' => $uphostery_part_id])
        ->andWhere(['type' => 'traveler'])
        ->all();
    }
    /* id = uphostery id */
    public static function getUphosteryAttachmentPI($id=null,$uphostery_part_id) {
        if ( $id === null ) {
            return UphosteryAttachment::find()
            ->all();
        }
        return UphosteryAttachment::find()
        ->where(['uphostery_id' => $id])
        ->andWhere(['uphostery_part_id' => $uphostery_part_id])
        ->andWhere(['type' => 'processing_inspection'])
        ->all();
    }
}
