<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WorkOrderArc;

/**
 * SearchWorkOrderArc represents the model behind the search form about `common\models\WorkOrderArc`.
 */
class SearchWorkOrderArc extends WorkOrderArc
{
    public $work_order_no;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'work_order_id', 'first_check', 'second_check', 'third_check', 'forth_check', 'form_tracking_no'], 'integer'],
            [['name', 'date', 'type','work_order_no'], 'safe'],
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
        $query = WorkOrderArc::find();
        $query->joinWith(['workOrder']);

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
            // 'work_order_id' => $this->work_order_id,
            'work_order_arc.date' => $this->date,
            'first_check' => $this->first_check,
            'second_check' => $this->second_check,
            'third_check' => $this->third_check,
            'forth_check' => $this->forth_check,
            'form_tracking_no' => $this->form_tracking_no,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'work_order.work_order_no', $this->work_order_no])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
