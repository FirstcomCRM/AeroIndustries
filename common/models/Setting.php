<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $value
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 45],
            [['value_2'], 'string', 'max' => 5],
            [['sort'], 'integer', 'max' => 5],
            [['deleted'], 'integer', 'max' => 1],
            [['desc', 'value'], 'string', 'max' => 255],
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
            'value' => 'Value',
            'value_2' => 'Value 2',
        ];
    }


    public static function getWorkNo($workType,$workScope,$workOrderNo) {
        $workType = Setting::find()->where(['deleted' => 0 ])->andWhere(['name' => 'product_type'])->andWhere(['value' => $workType])->one();
        $workScope = Setting::find()->where(['deleted' => 0 ])->andWhere(['name' => 'job_type'])->andWhere(['value' => $workScope])->one();
        $woNo = $workType->value_2 . sprintf("%006d", $workOrderNo) . $workScope->value_2;
        return $woNo;
    }

    public static function dataWorkType() {
        return ArrayHelper::map(Setting::find()->where(['deleted' => 0 ])->andWhere(['name' => 'product_type'])->orderBy('sort')->all(), 'value', 'value');
    }


    public static function dataWorkScope() {
        return ArrayHelper::map(Setting::find()->where(['deleted' => 0 ])->andWhere(['name' => 'job_type'])->orderBy('sort')->all(), 'value', 'value');
    }

    public static function dataWorkStatus() {
        return ArrayHelper::map(Setting::find()->where(['deleted' => 0 ])->andWhere(['name' => 'work_status'])->orderBy('sort')->all(), 'value', 'value');
    }

    public static function dataArcStatus() {
        return ArrayHelper::map(Setting::find()->where(['deleted' => 0 ])->andWhere(['name' => 'arc_status'])->orderBy('sort')->all(), 'value', 'value');
    }

    public static function dataIDType() {
        return ArrayHelper::map(Setting::find()->where(['deleted' => 0 ])->andWhere(['name' => 'id_tag_type'])->orderBy('sort')->all(), 'value', 'value');
    }

    public static function dataIdentifyFrom() {
        return ArrayHelper::map(Setting::find()->where(['deleted' => 0 ])->andWhere(['name' => 'identify_from'])->orderBy('sort')->all(), 'value', 'value');
    }

    public static function getUphosteryNo($uphosteryType,$uphosteryScope,$uphosteryNo) {
        $uphosteryType = Setting::find()->where(['deleted' => 0 ])->andWhere(['name' => 'product_type'])->andWhere(['value' => $uphosteryType])->one();
        $uphosteryScope = Setting::find()->where(['deleted' => 0 ])->andWhere(['name' => 'job_type'])->andWhere(['value' => $uphosteryScope])->one();
        $woNo = $uphosteryType->value_2 . sprintf("%006d", $uphosteryNo) . $uphosteryScope->value_2;
        return $woNo;
    }

    public static function dataUphosteryType() {
        return ArrayHelper::map(Setting::find()->where(['deleted' => 0 ])->andWhere(['name' => 'product_type'])->orderBy('sort')->all(), 'value', 'value');
    }


    public static function dataUphosteryScope() {
        return ArrayHelper::map(Setting::find()->where(['deleted' => 0 ])->andWhere(['name' => 'job_type'])->orderBy('sort')->all(), 'value', 'value');
    }

    public static function dataUphosteryStatus() {
        return ArrayHelper::map(Setting::find()->where(['deleted' => 0 ])->andWhere(['name' => 'uphostery_status'])->orderBy('sort')->all(), 'value', 'value');
    }
}
