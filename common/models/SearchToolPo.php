<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ToolPo;

/**
 * SearchToolPo represents the model behind the search form about `common\models\ToolPo`.
 */
class SearchToolPo extends ToolPo
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
            [['id', 'purchase_order_no', 'supplier_id', 'p_currency', 'clone', 'status', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['attention', 'supplier_ref_no', 'payment_addr', 'issue_date', 'delivery_date', 'p_term', 'ship_via', 'ship_to', 'remark', 'created', 'updated', 'approved','supplier_company_name'], 'safe'],
            [['subtotal', 'gst_rate', 'grand_total', 'usd_total', 'conversion'], 'number'],
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
        $query = ToolPo::find();
        $query->joinWith(['supplier']);
        $query->joinWith(['currency']);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);
        $dataProvider->query->where(['<>','tool_po.deleted', 1]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'purchase_order_no' => $this->purchase_order_no,
            'supplier_id' => $this->supplier_id,
            'issue_date' => $this->issue_date,
            'delivery_date' => $this->delivery_date,
            'p_currency' => $this->p_currency,
            'subtotal' => $this->subtotal,
            'gst_rate' => $this->gst_rate,
            'grand_total' => $this->grand_total,
            'usd_total' => $this->usd_total,
            'conversion' => $this->conversion,
            'clone' => $this->clone,
            'status' => $this->status,
            'created' => $this->created,
            'created_by' => $this->created_by,
            'updated' => $this->updated,
            'updated_by' => $this->updated_by,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'attention', $this->attention])
            ->andFilterWhere(['like', 'supplier_ref_no', $this->supplier_ref_no])
            ->andFilterWhere(['like', 'supplier.company_name', $this->supplier_company_name])
            ->andFilterWhere(['like', 'payment_addr', $this->payment_addr])
            ->andFilterWhere(['like', 'p_term', $this->p_term])
            ->andFilterWhere(['like', 'ship_via', $this->ship_via])
            ->andFilterWhere(['like', 'ship_to', $this->ship_to])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'approved', $this->approved]);

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
