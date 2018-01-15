<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Calibration;

/**
 * SearchCalibration represents the model behind the search form about `common\models\Calibration`.
 */
class SearchCalibration extends Calibration
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',  'created_by', 'updated_by', 'storage_location'], 'integer'],
            [['description', 'con_approval','manufacturer', 'model', 'serial_no', 'acceptance_criteria', 'date', 'due_date', 'con_limitation', 'created', 'updated'], 'safe'],
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
        $query = Calibration::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'date' => $this->date,
            'due_date' => $this->due_date,
            'con_approval' => $this->con_approval,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'manufacturer', $this->manufacturer])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'serial_no', $this->serial_no])
            ->andFilterWhere(['like', 'storage_location', $this->storage_location])
            ->andFilterWhere(['like', 'acceptance_criteria', $this->acceptance_criteria])
            ->andFilterWhere(['like', 'con_limitation', $this->con_limitation]);

        return $dataProvider;
    }
}
