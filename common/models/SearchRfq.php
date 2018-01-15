<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Rfq;

/**
 * SearchRfq represents the model behind the search form about `common\models\Rfq`.
 */
class SearchRfq extends Rfq
{
    public $supplier_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id', 'deleted'], 'integer'],
            [['date', 'quotation_no', 'remark','supplier_name','trace_certs','manufacturer'], 'safe'],
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
        $query = Rfq::find();
        $query->joinWith(['supplier']);

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
            'date' => $this->date,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'quotation_no', $this->quotation_no])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'manufacturer', $this->manufacturer])
            ->andFilterWhere(['like', 'trace_certs', $this->trace_certs])
            ->andFilterWhere(['like', 'supplier.company_name', $this->supplier_name]);

        return $dataProvider;
    }
}
