<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StockHistory;

/**
 * SearchStockHistory represents the model behind the search form about `common\models\StockHistory`.
 */
class SearchStockHistory extends StockHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'part_id', 'related_user'], 'integer'],
            [['reference_no', 'datetime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StockHistory::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'part_id' => $this->part_id,
            'related_user' => $this->related_user,
            'datetime' => $this->datetime,
        ]);

        $query->andFilterWhere(['like', 'reference_no', $this->reference_no]);

        return $dataProvider;
    }
}
