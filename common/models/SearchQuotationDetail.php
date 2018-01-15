<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\QuotationDetail;

/**
 * SearchQuotationDetail represents the model behind the search form about `common\models\QuotationDetail`.
 */
class SearchQuotationDetail extends QuotationDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quotation_id', 'group', 'quantity'], 'integer'],
            [['service_details', 'work_type', 'remark'], 'safe'],
            [['unit_price', 'subtotal'], 'number'],
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
        $query = QuotationDetail::find();

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
            'quotation_id' => $this->quotation_id,
            'group' => $this->group,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'subtotal' => $this->subtotal,
        ]);

        $query->andFilterWhere(['like', 'service_details', $this->service_details])
            ->andFilterWhere(['like', 'work_type', $this->work_type])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
