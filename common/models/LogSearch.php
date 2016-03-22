<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Log;

/**
 * LogSearch represents the model behind the search form about `common\models\Log`.
 */
class LogSearch extends Log
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'handle_id', 'created_at', 'updated_at'], 'integer'],
            [['user_name', 'user_ip', 'user_agent', 'title', 'controller', 'action', 'result', 'describe'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Log::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'handle_id' => $this->handle_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'user_ip', $this->user_ip])
            ->andFilterWhere(['like', 'user_agent', $this->user_agent])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'controller', $this->controller])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'result', $this->result])
            ->andFilterWhere(['like', 'describe', $this->describe]);

        return $dataProvider;
    }
}
