<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "uphostery_sub".
 *
 * @property integer $id
 * @property string $part_no
 * @property string $eligibility
 * @property string $serial_no
 * @property string $batch_no
 * @property integer $location_id
 * @property integer $template_id
 * @property integer $quantity
 * @property string $pma_used
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 * @property string $status
 * @property integer $deleted
 */
class UphosterySub extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uphostery_sub';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location_id', 'template_id', 'quantity', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['pma_used'], 'string'],
            [['created', 'updated'], 'safe'],
            [['part_no', 'serial_no', 'batch_no', 'status'], 'string', 'max' => 45],
            [['eligibility'], 'string', 'max' => 50],
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
            'eligibility' => 'Eligibility',
            'serial_no' => 'Serial No',
            'batch_no' => 'Batch No',
            'location_id' => 'Location ID',
            'template_id' => 'Template ID',
            'quantity' => 'Quantity',
            'pma_used' => 'Pma Used',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'deleted' => 'Deleted',
        ];
    }
}
