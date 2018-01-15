<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property integer $id
 * @property string $iso
 * @property string $name
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iso', 'name'], 'required'],
            [['iso'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 200],
            [['name'], 'unique'],
            [['status','updated'], 'safe'],
            [['rate'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iso' => 'Iso',
            'name' => 'Name',
            'updated' => 'Last Update',
            'rate' => 'Exchange Rate (To 1 USD)',
        ];
    }
    public static function dataCurrency($id=null) {
        return ArrayHelper::map(Currency::find()->where(['status'=>'active'])->all(), 'id', 'name');
    }
    public static function dataCurrencyISO($id=null) {
        return ArrayHelper::map(Currency::find()->where(['status'=>'active'])->all(), 'id', 'iso');
    }
    public static function dataCurrencyRate($id=null) {
        return ArrayHelper::map(Currency::find()->where(['status'=>'active'])->all(), 'id', 'rate');
    }
}
