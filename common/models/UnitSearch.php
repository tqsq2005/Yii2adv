<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Unit;

/**
 * UnitSearch represents the model behind the search form about `common\models\Unit`.
 */
class UnitSearch extends Unit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unitcode', 'unitname', 'corporation', 'address1', 'office', 'oname', 'tel', 'fax', 'unitkind', 'rank', 'rsystem', 'upunitname', 'upunitcode', 'postcode', 'char1', 'date1', 'leader', 'leadertel', 'jsxzdate', 'jsxhdate', 'jsbdate'], 'safe'],
            [['corpflag', 'id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
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
        $query = Unit::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'corpflag' => $this->corpflag,
            'id' => $this->id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'unitcode', $this->unitcode])
            ->andFilterWhere(['like', 'unitname', $this->unitname])
            ->andFilterWhere(['like', 'corporation', $this->corporation])
            ->andFilterWhere(['like', 'address1', $this->address1])
            ->andFilterWhere(['like', 'office', $this->office])
            ->andFilterWhere(['like', 'oname', $this->oname])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'unitkind', $this->unitkind])
            ->andFilterWhere(['like', 'rank', $this->rank])
            ->andFilterWhere(['like', 'rsystem', $this->rsystem])
            ->andFilterWhere(['like', 'upunitname', $this->upunitname])
            ->andFilterWhere(['like', 'upunitcode', $this->upunitcode])
            ->andFilterWhere(['like', 'postcode', $this->postcode])
            ->andFilterWhere(['like', 'char1', $this->char1])
            ->andFilterWhere(['like', 'date1', $this->date1])
            ->andFilterWhere(['like', 'leader', $this->leader])
            ->andFilterWhere(['like', 'leadertel', $this->leadertel])
            ->andFilterWhere(['like', 'jsxzdate', $this->jsxzdate])
            ->andFilterWhere(['like', 'jsxhdate', $this->jsxhdate])
            ->andFilterWhere(['like', 'jsbdate', $this->jsbdate]);

        return $dataProvider;
    }
}
