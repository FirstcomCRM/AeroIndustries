<?php

namespace common\models;

use Yii;

use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "storage_location".
 *
 * @property integer $id
 * @property string $name
 * @property string $size
 */
class StorageLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'storage_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'size'], 'string', 'max' => 45],
            [['status'], 'safe'],
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
            'size' => 'Location',
        ];
    }
    public static function dataLocation($id=null) {
        return ArrayHelper::map(StorageLocation::find()->where(['<>','status','inactive'])->andWhere(['<>','deleted','1'])->all(), 'id', 'name');
    }

    public static function getStorageLocation($id=null) {
        if ( $id === null ) {
            $storage_location = StorageLocation::find()->where(['<>','status','inactive'])->all();
            return $storage_location;
        }
        $storage_location = StorageLocation::find()->where(['id' => $id])->one();
        return $storage_location;
    }

}
