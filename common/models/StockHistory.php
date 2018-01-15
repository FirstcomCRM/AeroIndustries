<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_history".
 *
 * @property integer $id
 * @property integer $part_id
 * @property string $reference_no
 * @property integer $related_user
 * @property string $datetime
 */
class StockHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['part_id', 'related_user','qty'], 'integer'],
            [['datetime'], 'safe'],
            [['reference_no','type'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'part_id' => 'Part ID',
            'qty' => 'Quantity',
            'reference_no' => 'Reference No',
            'related_user' => 'Related User',
            'datetime' => 'Datetime',
        ];
    }
    public function getRelatedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'related_user'])->from(['related_user' => User::tableName()]);
    }
    public function getPart()
    {
        return $this->hasOne(Part::className(), ['id' => 'part_id']);
    }
}
