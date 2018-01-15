<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Part;

/**
 * SearchPart represents the model behind the search form about `common\models\Part`.
 */
class SearchPart extends Part
{   
    public $category;
    public $quantity_in_stock;
    public $unit;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'status'], 'integer'],
            [['part_no', 'desc', 'default_unit_price', 'created', 'updated','quantity_in_stock','unit'], 'safe'],
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
        $query = Part::find();
        $query->joinWith(['category']);
        $query->joinWith(['unit']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->query->where(['<>','part.deleted', 1]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'part_no', $this->part_no])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'default_unit_price', $this->default_unit_price]);

        return $dataProvider;
    }

    public static function stockTotal($partId)
    {   
        $totalAmount = 0;
        $query = "  SELECT 
                        sum(s.quantity) as stockQuantity
                    FROM 
                        stock as s 
                    WHERE 
                        s.part_id = $partId AND
                        s.status = 1
                    ;
                ";
        $totalQuantity = Yii::$app->db->createCommand($query)->queryOne();
        $quantity = $totalQuantity['stockQuantity'];
        return $quantity;

    }
}
