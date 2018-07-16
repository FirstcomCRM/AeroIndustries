<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "calibration".
 *
 * @property integer $id
 * @property string $description
 * @property string $manufacturer
 * @property string $model
 * @property string $serial_no
 * @property string $storage_location
 * @property string $acceptance_criteria
 * @property string $date
 * @property string $due_date
 * @property integer $con_approval
 * @property string $con_limitation
 * @property integer $created
 * @property integer $updated
 */
class Calibration extends \yii\db\ActiveRecord
{
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calibration';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'due_date', 'created', 'updated'], 'safe'],
            [['created_by', 'updated_by', 'storage_location','deleted','tool_id'], 'integer'],
            [['description', 'con_limitation'], 'string', 'max' => 255],
            [['manufacturer'], 'string', 'max' => 55],
            [['model', 'serial_no'], 'string', 'max' => 45],
            [['acceptance_criteria'], 'string', 'max' => 500],
            [['con_approval'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'tool' => 'Tool',
            'manufacturer' => 'Manufacturer',
            'model' => 'Model',
            'tool_id' => 'Tool',
            'serial_no' => 'Serial No',
            'storage_location' => 'Storage Location',
            'acceptance_criteria' => 'Acceptance Criteria',
            'date' => 'Date',
            'due_date' => 'Due Date',
            'con_approval' => 'Conditional Approval',
            'con_limitation' => 'Conditional Limitation',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
