<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Quotation;

/**
 * SearchQuotation represents the model behind the search form about `common\models\Quotation`.
 */
class SearchQuotation extends Quotation
{
    public $customer;
    public $currency;
    public $customer_name;
    public $from_date;
    public $to_date;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'lead_time', 'p_currency'], 'integer'],
            [['reference', 'date', 'attention', 'p_term', 'd_term', 'remark', 'status', 'created', 'updated','approved','customer_name','from_date', 'to_date','quotation_no'], 'safe'],
            [['subtotal', 'grand_total','gst_rate'], 'number'],
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
        $query = Quotation::find();
        $query->joinWith(['customer']);
        $query->joinWith(['currency']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);
        $dataProvider->query->where(['<>','quotation.deleted', 1]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'date' => $this->date,
            'lead_time' => $this->lead_time,
            'p_currency' => $this->p_currency,
            'subtotal' => $this->subtotal,
            'gst_rate' => $this->gst_rate,
            'grand_total' => $this->grand_total,
            'created' => $this->created,
            'approved' => $this->approved,
            'updated' => $this->updated,
        ]);

        // d($this->rental_no);exit;
        $endDate = '';
        if ( $this->to_date ) {
            $endDate = $this->to_date;
        }
        $startDate = '';
        if ( $this->from_date ) {
            $startDate = $this->from_date;
        }


        $query->andFilterWhere(['like', 'reference', $this->reference])
            // ->andFilterWhere(['like', 'customer.name', $this->name])
            ->andFilterWhere(['like', 'attention', $this->attention])
            ->andFilterWhere(['like', 'quotation_no', $this->quotation_no])
            ->andFilterWhere(['like', 'p_term', $this->p_term])
            ->andFilterWhere(['like', 'd_term', $this->d_term])
            ->andFilterWhere(['like', 'customer.name', $this->customer_name])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['>=', 'quotation.date', $startDate])
            ->andFilterWhere(['<=', 'quotation.date', $endDate]);

        return $dataProvider;
    }
    public static function pageTotal($provider, $fieldName)
    {
        $total=0;
        
        foreach($provider as $item){
            $total+=$item[$fieldName];
        }
        $total = number_format((float)$total, 2, '.', '');

        return $total;
    }
}

