<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer;

/**
 * SearchCustomer represents the model behind the search form about `common\models\Customer`.
 */
class SearchCustomer extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'b_currency'], 'integer'],
            [['name', 'addr_1', 'addr_2', 'contact_person', 'email', 'contact_no', 'title', 's_addr_1', 's_addr_2', 'b_addr_1', 'b_addr_2', 'b_term', 'status', 'created', 'updated'], 'safe'],
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
        $query = Customer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);
        $dataProvider->query->where(['<>','customer.deleted', 1]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'b_currency' => $this->b_currency,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'addr_1', $this->addr_1])
            ->andFilterWhere(['like', 'addr_2', $this->addr_2])
            ->andFilterWhere(['like', 'contact_person', $this->contact_person])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 's_addr_1', $this->s_addr_1])
            ->andFilterWhere(['like', 's_addr_2', $this->s_addr_2])
            ->andFilterWhere(['like', 'b_addr_1', $this->b_addr_1])
            ->andFilterWhere(['like', 'b_addr_2', $this->b_addr_2])
            ->andFilterWhere(['like', 'b_term', $this->b_term])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
