<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Helpmenu;

/**
 * HelpmenuSearch represents the model behind the search form about `backend\models\Helpmenu`.
 */
class HelpmenuSearch extends Helpmenu
{
    public function rules()
    {
        return [
            [['id', 'corpflag', 'is_private', 'created_at', 'updated_at'], 'integer'],
            [['unitcode', 'unitname', 'upunitcode', 'upunitname', 'content', 'introduce', 'do_man', 'do_date', 'do_man_unit', 'advise', 'answer', 'answerdate', 'answercontent'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params, $upunitcode)
    {
        $query = Helpmenu::find()->andFilterWhere([
            'upunitcode' => $upunitcode,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'upunitcode' => $this->upunitcode,
            'corpflag' => $this->corpflag,
            'do_date' => $this->do_date,
            'answerdate' => $this->answerdate,
            'is_private' => $this->is_private,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'unitcode', $this->unitcode])
            ->andFilterWhere(['like', 'unitname', $this->unitname])
            //->andFilterWhere(['like', 'upunitcode', $this->upunitcode])
            ->andFilterWhere(['like', 'upunitname', $this->upunitname])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'introduce', $this->introduce])
            ->andFilterWhere(['like', 'do_man', $this->do_man])
            ->andFilterWhere(['like', 'do_man_unit', $this->do_man_unit])
            ->andFilterWhere(['like', 'advise', $this->advise])
            ->andFilterWhere(['like', 'answer', $this->answer])
            ->andFilterWhere(['like', 'answercontent', $this->answercontent]);

        return $dataProvider;
    }
}
