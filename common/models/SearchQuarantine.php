<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Quarantine;

/**
 * SearchQuarantine represents the model behind the search form about `common\models\Quarantine`.
 */
class SearchQuarantine extends Quarantine
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'work_order_id', 'quantity', 'status'], 'integer'],
            [['part_no', 'serial_no', 'batch_no', 'lot_no', 'desc', 'reason', 'date', 'created', 'updated'], 'safe'],
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
        $query = Quarantine::find();
        $query->joinWith(['workOrder']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->query->where(['<>','quarantine.status', 0]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'quarantine.part_no' => $this->part_no,
            'quarantine.work_order_id' => $this->work_order_id,
            'quantity' => $this->quantity,
            'date' => $this->date,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'serial_no', $this->serial_no])
            ->andFilterWhere(['like', 'batch_no', $this->batch_no])
            ->andFilterWhere(['like', 'lot_no', $this->lot_no])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
