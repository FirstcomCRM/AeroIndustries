<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Stock;

/**
 * SearchStock represents the model behind the search form about `common\models\Stock`.
 */
class SearchStock extends Stock
{   
    public $supplier;
    public $part;
    public $part_category_id;
    public $createdBy;
    public $updatedBy;
    public $storage;
    public $total_quantity;
    public $unit;
    public $cnt;
    public $subUnit;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id', 'part_id', 'quantity', 'status','purchase_order_id'], 'integer'],
            [['desc', 'storage_location_id', 'batch_no', 'note', 'expiration_date','unit','total_quantity','cnt','part_category_id','subUnit'], 'safe'],
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
        $query = Stock::find();
        $query->joinWith(['supplier']);
        $query->joinWith(['createdBy','updatedBy']);
        $query->joinWith(['storage']);
        $query->joinWith(['part']);
        $query->joinWith(['unit']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);
        $dataProvider->query->where(['stock.status' => 'active']);
        // $dataProvider->query->groupBy(['part_no']);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'stock.supplier_id' => $this->supplier_id,
            'purchase_order_id' => $this->purchase_order_id,
            'part_id' => $this->part_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'expiration_date' => $this->expiration_date,
            'part.category_id' => $this->part_category_id,
            'stock.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'storage_location_id', $this->storage_location_id])
            ->andFilterWhere(['like', 'batch_no', $this->batch_no])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }  

    public function searchInventory($params)
    {
        $query = Stock::find();
        $query->joinWith(['supplier']);
        $query->joinWith(['createdBy','updatedBy']);
        $query->joinWith(['storage']);
        $query->joinWith(['part']);
        $query->joinWith(['unit']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['expiration_date'=>SORT_ASC]]
        ]);
        $dataProvider->query->where(['stock.status' => 'active']);
        // $dataProvider->query->groupBy(['part_no']);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'stock.supplier_id' => $this->supplier_id,
            'purchase_order_id' => $this->purchase_order_id,
            'part_id' => $this->part_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'expiration_date' => $this->expiration_date,
            'part.category_id' => $this->part_category_id,
            'stock.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'storage_location_id', $this->storage_location_id])
            ->andFilterWhere(['like', 'batch_no', $this->batch_no])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }

    public static function pageTotal($provider, $fieldName)
    {
        $total=0;
        foreach($provider as $item){
            $total+=$item[$fieldName];
        }

        return $total;
    }

    public static function subTimesQty($fieldName1, $fieldName2)
    {
        $total=0;
        
        if ( $fieldName2 > 0 ) {
            $total = $fieldName1 * $fieldName2;
        } else {
            $total = $fieldName1;
        }

        return $total;
    }

    public static function subTimesQtyTotal($provider, $fieldName1, $fieldName2)
    {
        $total=0;
        
        foreach($provider as $item){

            if (  $item[$fieldName2] > 0 ) {
                $temp = $item[$fieldName1] * $item[$fieldName2];
            } else {
                $temp = $item[$fieldName1];
            }

            $total += $temp;
        }


        return $total;
    }



    public function searchStock($partId,$params)
    {
        $query = Stock::find();
        $query->joinWith(['supplier']);
        $query->joinWith(['createdBy','updatedBy']);
        $query->joinWith(['storage']);
        $query->joinWith(['part']);
        $query->joinWith(['unit']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);
        // $dataProvider->query->groupBy(['part_no']);

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
            'purchase_order_id' => $this->purchase_order_id,
            'part_id' => $this->part_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'expiration_date' => $this->expiration_date,
            'part.category_id' => $this->part_category_id,
            'stock.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'storage_location_id', $this->storage_location_id])
            ->andFilterWhere(['like', 'batch_no', $this->batch_no])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }


}
