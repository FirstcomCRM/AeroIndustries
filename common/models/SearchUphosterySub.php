<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UphosterySub;

/**
 * SearchUphosterySub represents the model behind the search form about `common\models\UphosterySub`.
 */
class SearchUphosterySub extends UphosterySub
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'location_id', 'template_id', 'quantity', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['part_no', 'eligibility', 'serial_no', 'batch_no', 'pma_used', 'created', 'updated', 'status'], 'safe'],
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
        $query = UphosterySub::find();

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
            'location_id' => $this->location_id,
            'template_id' => $this->template_id,
            'quantity' => $this->quantity,
            'created' => $this->created,
            'created_by' => $this->created_by,
            'updated' => $this->updated,
            'updated_by' => $this->updated_by,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'part_no', $this->part_no])
            ->andFilterWhere(['like', 'eligibility', $this->eligibility])
            ->andFilterWhere(['like', 'serial_no', $this->serial_no])
            ->andFilterWhere(['like', 'batch_no', $this->batch_no])
            ->andFilterWhere(['like', 'pma_used', $this->pma_used])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
