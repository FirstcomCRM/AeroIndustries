<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DeliveryOrder;

/**
 * SearchDeliveryOrder represents the model behind the search form about `common\models\DeliveryOrder`.
 */
class SearchDeliveryOrder extends DeliveryOrder
{   
    public $from_date;
    public $to_date;
    public $customer_name;
    public $work_order_no;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'created_by'], 'integer'],
            [['delivery_order_no', 'date', 'ship_to', 'contact_no', 'status', 'created','from_date', 'to_date','customer_name','work_order_no'], 'safe'],
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
        $query = DeliveryOrder::find();
        $query->joinWith(['customer']);
        // $query->joinWith(['work_order']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);
        $dataProvider->query->where(['<>','delivery_order.deleted', 1]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $delivery_order_id = '';
        if (isset($_GET['delivery_order_id']) ) {
            $delivery_order_id = $_GET['delivery_order_id'];
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'delivery_order.id' => $delivery_order_id,
            'date' => $this->date,
            'customer_id' => $this->customer_id,
            'created' => $this->created,
            'created_by' => $this->created_by,
        ]);
        $endDate = '';
        if ( $this->to_date ) {
            $endDate = $this->to_date;
        }
        $startDate = '';
        if ( $this->from_date ) {
            $startDate = $this->from_date;
        }

        $query->andFilterWhere(['like', 'delivery_order_no', $this->delivery_order_no])
            ->andFilterWhere(['like', 'ship_to', $this->ship_to])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'customer.name', $this->customer_name])
            // ->andFilterWhere(['like', 'work_order.work_order_no', $this->work_order_no])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['>=', 'delivery_order.date', $startDate])
            ->andFilterWhere(['<=', 'delivery_order.date', $endDate]);

        return $dataProvider;
    }
}
