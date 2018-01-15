<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "template_alt".
 *
 * @property integer $id
 * @property integer $template_id
 * @property string $part_no
 * @property string $created
 * @property integer $created_by
 * @property string $updated
 * @property integer $updated_by
 */
class TemplateAlt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_alt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['part_no'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_id' => 'Template ID',
            'part_no' => 'Alternative Part No',
            'created' => 'Created',
            'created_by' => 'Created By',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
        ];
    }
}
