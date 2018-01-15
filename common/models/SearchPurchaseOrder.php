<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PurchaseOrder;

/**
 * SearchPurchaseOrder represents the model behind the search form about `common\models\PurchaseOrder`.
 */
class SearchPurchaseOrder extends PurchaseOrder
{
    public $currency;
    public $supplier;
    public $supplier_company_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id', 'p_currency', 'clone'], 'integer'],
            [['supplier_ref_no', 'purchase_order_no', 'issue_date', 'delivery_date', 'p_term', 'ship_via', 'ship_to', 'remark', 'created', 'updated','approved','supplier_company_name'], 'safe'],
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
        $query = PurchaseOrder::find();
        $query->joinWith(['supplier']);
        $query->joinWith(['currency']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);
        $dataProvider->query->where(['<>','purchase_order.deleted', 1]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'supplier_id' => $this->supplier_id,
            'issue_date' => $this->issue_date,
            'delivery_date' => $this->delivery_date,
            'purchase_order.p_currency' => $this->p_currency,
            'subtotal' => $this->subtotal,
            'gst_rate' => $this->gst_rate,
            'grand_total' => $this->grand_total,
            'clone' => $this->clone,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'supplier_ref_no', $this->supplier_ref_no])
            ->andFilterWhere(['like', 'supplier.company_name', $this->supplier_company_name])
            ->andFilterWhere(['like', 'purchase_order_no', $this->purchase_order_no])
            ->andFilterWhere(['like', 'p_term', $this->p_term])
            ->andFilterWhere(['like', 'ship_via', $this->ship_via])
            ->andFilterWhere(['like', 'approved', $this->approved])
            ->andFilterWhere(['like', 'ship_to', $this->ship_to])
            ->andFilterWhere(['like', 'remark', $this->remark]);

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
