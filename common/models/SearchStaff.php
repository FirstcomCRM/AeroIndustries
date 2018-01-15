<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Staff;

/**
 * SearchStaff represents the model behind the search form about `common\models\Staff`.
 */
class SearchStaff extends Staff
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'group_id', 'status'], 'integer'],
            [['name', 'staff_no', 'department', 'date_joined', 'title', 'stamp', 'auth_no', 'created', 'updated'], 'safe'],
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
        $query = Staff::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->query->where(['<>','staff.deleted', 1]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date_joined' => $this->date_joined,
            'group_id' => $this->group_id,
            'status' => $this->status,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'staff_no', $this->staff_no])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'stamp', $this->stamp])
            ->andFilterWhere(['like', 'auth_no', $this->auth_no]);

        return $dataProvider;
    }
}
