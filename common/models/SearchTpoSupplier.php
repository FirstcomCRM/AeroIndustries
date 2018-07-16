<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TpoSupplier;

/**
 * SearchTpoSupplier represents the model behind the search form about `common\models\TpoSupplier`.
 */
class SearchTpoSupplier extends TpoSupplier
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'p_currency', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['company_name', 'addr', 'contact_person', 'email', 'contact_no', 'title', 'p_addr_1', 'p_addr_2', 'p_addr_3', 'scope_of_approval', 'survey_date', 'approval_status', 'status', 'created', 'updated'], 'safe'],
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
        $query = TpoSupplier::find();

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
            'p_currency' => $this->p_currency,
            'survey_date' => $this->survey_date,
            'created_by' => $this->created_by,
            'created' => $this->created,
            'updated_by' => $this->updated_by,
            'updated' => $this->updated,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'addr', $this->addr])
            ->andFilterWhere(['like', 'contact_person', $this->contact_person])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'p_addr_1', $this->p_addr_1])
            ->andFilterWhere(['like', 'p_addr_2', $this->p_addr_2])
            ->andFilterWhere(['like', 'p_addr_3', $this->p_addr_3])
            ->andFilterWhere(['like', 'scope_of_approval', $this->scope_of_approval])
            ->andFilterWhere(['like', 'approval_status', $this->approval_status])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
