<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Event;

/**
 * EventSearch represents the model behind the search form about `backend\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'allDay', 'editable', 'startEditable', 'durationEditable', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'description', 'start', 'end', 'dow', 'url', 'className', 'source', 'color', 'backgroundColor', 'borderColor', 'textColor'], 'safe'],
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
        $query = Event::find()->indexBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'allDay' => $this->allDay,
            'editable' => $this->editable,
            'startEditable' => $this->startEditable,
            'durationEditable' => $this->durationEditable,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'start', $this->start])
            ->andFilterWhere(['like', 'end', $this->end])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'dow', $this->dow])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'className', $this->className])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'backgroundColor', $this->backgroundColor])
            ->andFilterWhere(['like', 'borderColor', $this->borderColor])
            ->andFilterWhere(['like', 'textColor', $this->textColor]);

        return $dataProvider;
    }
}
