<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "uphostery_cust_part".
 *
 * @property integer $id
 * @property string $serial_no
 * @property string $part_no
 * @property string $uphostery_type
 * @property integer $uphostery_id
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
 * @property integer $created
 * @property integer $created_by
 * @property string $update
 * @property integer $updated_by
 */
class UphosteryCustPart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uphostery_cust_part';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uphostery_type'], 'string'],
            [['uphostery_id', 'template_id', 'quantity','created_by', 'updated_by'], 'integer'],
            [['created', 'update'], 'safe'],
            [['serial_no', 'part_no'], 'string', 'max' => 45],
            [['desc'], 'string', 'max' => 1000],
            [['remark'], 'string', 'max' => 500],
            [['qc_notes', 'inspection', 'corrective', 'disposition_note', 'hidden_damage'], 'string', 'max' => 1000],
            [['arc_remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serial_no' => 'Serial No',
            'part_no' => 'Part No',
            'uphostery_type' => 'Upholstery Type',
            'uphostery_id' => 'Upholstery ID',
            'template_id' => 'Template',
            'quantity' => 'Quantity',
            'desc' => 'Desc',
            'remark' => 'Remark',
            'qc_notes' => 'QC Notes',
            'inspection' => 'Inspection',
            'corrective' => 'Corrective Action',
            'disposition_note' => 'Disposition Note',
            'hidden_damage' => 'Hidden Damage',
            'arc_remark' => 'Arc Remark',
            'created' => 'Created',
            'created_by' => 'Created By',
            'update' => 'Update',
            'updated_by' => 'Updated By',
        ];
    }
    /* id = work order id */
    public static function getUphosteryCustPart($id=null) {
        if ( $id === null ) {
            return UphosteryCustPart::find()->all();
        }
        return UphosteryCustPart::find()->where(['uphostery_id' => $id])->all();
    }
}
