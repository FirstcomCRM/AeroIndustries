<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "capability".
 *
 * @property integer $id
 * @property string $part_no
 * @property string $description
 * @property string $manufacturer
 * @property string $workscope
 * @property string $ata_chapter
 * @property string $rating
 * @property integer $deleted
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 */
class Capability extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'capability';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deleted', 'created_by', 'updated_by'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['part_no', 'workscope','ref_document_no'], 'string', 'max' => 45],
            [['description', 'manufacturer'], 'string', 'max' => 100],
            [['ata_chapter'], 'string', 'max' => 14],
            [['rating'], 'string', 'max' => 5],
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
            'description' => 'Description',
            'manufacturer' => 'Manufacturer',
            'workscope' => 'Workscope',
            'ata_chapter' => 'Ata Chapter',
            'ref_document_no' => 'Reference Document No.',
            'rating' => 'Rating',
            'deleted' => 'Deleted',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
        ];
    }

    public static function dataPartNo() {
        return ArrayHelper::map(Capability::find()->where(['<>','deleted','1'])->all(), 'part_no', 'part_no');
    }

    public static function getPartDesc($partNo) {
        $capability = Capability::find()->where(['part_no' => $partNo])->one();
        return $capability->description;
    }
}
