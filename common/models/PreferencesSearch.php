<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Preferences;

/**
 * PreferencesSearch represents the model behind the search form about `common\models\Preferences`.
 */
class PreferencesSearch extends Preferences
{
    public function rules()
    {
        return [
            [['codes', 'name1', 'classmark', 'classmarkcn'], 'safe'],
            [['changemark', 'id', 'status', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Preferences::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            /*'pagination' => [
                'pageSize' => 10,
            ],*/
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'changemark' => $this->changemark,
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'codes', $this->codes])
            ->andFilterWhere(['like', 'name1', $this->name1])
            ->andFilterWhere(['like', 'classmark', $this->classmark])
            ->andFilterWhere(['like', 'classmarkcn', $this->classmarkcn]);

        return $dataProvider;
    }
}
