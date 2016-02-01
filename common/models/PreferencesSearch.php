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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codes', 'name1', 'classmark', 'classmarkcn'], 'safe'],
            [['changemark', 'id', 'status', 'created_at', 'updated_at'], 'integer'],
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
        $query = Preferences::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //设置分页
            'pagination' => [
                'pageSize' => 10,
            ],
            //排序
            'sort' => [
                //默认排序
                'defaultOrder' => [
                    'classmark' => SORT_ASC,
                    'codes' => SORT_ASC,
                ],
                //是否允许多个属性排序，默认是否，即只允许一个属性进行排序
                //'enableMultiSort' => true,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
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
