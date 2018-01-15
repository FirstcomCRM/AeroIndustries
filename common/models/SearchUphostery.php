<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Uphostery;

/**
 * SearchUphostery represents the model behind the search form about `common\models\Uphostery`.
 */
class SearchUphostery extends Uphostery
{
    public $customer_name;
    public $from_date;
    public $to_date;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uphostery_no', 'customer_id', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['customer_po_no', 'date', 'received_date', 'uphostery_type', 'remark', 'qc_notes', 'created', 'updated', 'status','customer_name','from_date', 'to_date','uphostery_scope'], 'safe'],
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
        $query = Uphostery::find();
        $query->joinWith(['customer']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
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
            'uphostery_no' => $this->uphostery_no,
            'customer_id' => $this->customer_id,
            'date' => $this->date,
            'received_date' => $this->received_date,
            'created' => $this->created,
            'created_by' => $this->created_by,
            'updated' => $this->updated,
            'updated_by' => $this->updated_by,
            'deleted' => $this->deleted,
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

        $query->andFilterWhere(['like', 'customer_po_no', $this->customer_po_no])
            ->andFilterWhere(['like', 'uphostery_type', $this->uphostery_type])
            ->andFilterWhere(['like', 'uphostery_scope', $this->uphostery_scope])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'qc_notes', $this->qc_notes])
            ->andFilterWhere(['like', 'customer.name', $this->customer_name])
            ->andFilterWhere(['like', 'uphostery.status', $this->status])
            ->andFilterWhere(['>=', 'uphostery.date', $startDate])
            ->andFilterWhere(['<=', 'uphostery.date', $endDate]);

        return $dataProvider;
    }
}
