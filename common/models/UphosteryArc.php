<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "uphostery_arc".
 *
 * @property integer $id
 * @property integer $uphostery_id
 * @property string $date
 * @property string $type
 * @property integer $first_check
 * @property integer $second_check
 * @property integer $form_tracking_no
 */
class UphosteryArc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uphostery_arc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uphostery_id', 'uphostery_part_id', 'first_check', 'second_check', 'third_check', 'forth_check','is_tracking_no','form_tracking_no'], 'integer'],
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
            'uphostery_id' => 'Uphostery No.',
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
    /* id = uphostery id */
    public static function getUphosteryArc($id=null,$uphostery_part_id) {
        if ( $id === null ) {
            return UphosteryArc::find()->all();
        }
        return UphosteryArc::find()->where(['uphostery_id' => $id])->andWhere(['uphostery_part_id'=>$uphostery_part_id])->all();
    }
    public function getUphostery(){
        return $this->hasOne(Uphostery::className(), ['id' => 'uphostery_id']);
    }
}
