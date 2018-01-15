<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "staff_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 */
class StaffGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'desc'], 'string', 'max' => 45],
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
        ];
    }

    public static function getStaffGroup($id=null) {
        if ( $id === null ) {
            return StaffGroup::find()->all();
        }
        return StaffGroup::find()->where(['id' => $id])->one();
    }
}
