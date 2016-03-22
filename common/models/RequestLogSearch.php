<?php
/**
 * Copyright (c) 2016. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\RequestLog;

class RequestLogSearch extends RequestLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [];
        foreach ($this->attributes() as $attribute) {
            $rules[$attribute] = [$attribute, 'safe'];
        }
        return $rules;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = static::find()
            ->joinWith(['user'])
            ->orderBy(['datetime' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        //$query->andFilterWhere(['like', 'app_id', $this->app_id]);
        $query->andFilterWhere(['like', 'route', $this->route]);
        $query->andFilterWhere(['like', 'params', $this->params]);
        $query->andFilterWhere(['user_id' => $this->user_id]);
        $query->andFilterWhere(['like', 'ip', $this->ip]);
        $query->andFilterWhere(['like', 'datetime', $this->datetime]);

        return $dataProvider;
    }
}
