<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tool;

/**
 * SearchTool represents the model behind the search form about `common\models\Tool`.
 */
class SearchTool extends Tool
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id', 'general_po_id', 'storage_location_id', 'receiver_no', 'part_id', 'quantity', 'unit_id', 'shelf_life', 'hour_used', 'time_used', 'status', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['desc', 'batch_no', 'note', 'expiration_date', 'received', 'created', 'updated'], 'safe'],
            [['unit_price'], 'number'],
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
        $query = Tool::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);
        $dataProvider->query->where(['<>','deleted', 1]);

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
            'general_po_id' => $this->general_po_id,
            'storage_location_id' => $this->storage_location_id,
            'receiver_no' => $this->receiver_no,
            'part_id' => $this->part_id,
            'quantity' => $this->quantity,
            'unit_id' => $this->unit_id,
            'unit_price' => $this->unit_price,
            'shelf_life' => $this->shelf_life,
            'hour_used' => $this->hour_used,
            'time_used' => $this->time_used,
            'expiration_date' => $this->expiration_date,
            'status' => $this->status,
            'received' => $this->received,
            'created' => $this->created,
            'created_by' => $this->created_by,
            'updated' => $this->updated,
            'updated_by' => $this->updated_by,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'batch_no', $this->batch_no])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }



    public function searchTool($partId,$params)
    {
        $query = Tool::find();

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
        $this->part_id = $partId;

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'supplier_id' => $this->supplier_id,
            'general_po_id' => $this->general_po_id,
            'storage_location_id' => $this->storage_location_id,
            'receiver_no' => $this->receiver_no,
            'part_id' => $this->part_id,
            'quantity' => $this->quantity,
            'unit_id' => $this->unit_id,
            'unit_price' => $this->unit_price,
            'shelf_life' => $this->shelf_life,
            'hour_used' => $this->hour_used,
            'time_used' => $this->time_used,
            'expiration_date' => $this->expiration_date,
            'status' => $this->status,
            'received' => $this->received,
            'created' => $this->created,
            'created_by' => $this->created_by,
            'updated' => $this->updated,
            'updated_by' => $this->updated_by,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'batch_no', $this->batch_no])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
