<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Events;

/**
 * EventsSearch represents the model behind the search form about `common\models\Events`.
 */
class EventsSearch extends Events
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'time', 'created_at', 'updated_at'], 'integer'],
            [['title', 'data'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Events::find();

        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 10;
        $dataProvider = new ActiveDataProvider([
            'query'         => $query,
            'pagination'    =>  [
                'pageSize' => $pageSize,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        //$query->joinWith('user');

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'time' => $this->time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
