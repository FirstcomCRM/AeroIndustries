<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "part_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $created
 * @property string $updated
 */
class PartCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'part_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by','deleted'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['name'], 'string', 'max' => 45],
            [['desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
    public static function dataPartCategory($id=null) {
        return ArrayHelper::map(PartCategory::find()->where(['<>','status','inactive'])->all(), 'id', 'name');
    }
}
