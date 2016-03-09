<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Marry;

/**
 * MarrySearch represents the model behind the search form about `backend\models\Marry`.
 */
class MarrySearch extends Marry
{
    public function rules()
    {
        return [
            [['id', 'marrowno', 'mid'], 'integer'],
            [['code1', 'marrow', 'because', 'becausedate', 'mfcode', 'mhkdz', 'marrowdate', 'marrowunit', 'othertel', 'hfp', 'maddr', 'mpostcode', 'hmarry', 'marrycode', 'mem', 'unit', 'personal_id', 'do_man'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Marry::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //关联personal表
        $query->joinWith(['personal'], true, 'INNER JOIN');

        //外部字段排序
        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc'  => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC],
                ],
                'code1' => [
                    'asc'  => ['code1' => SORT_ASC],
                    'desc' => ['code1' => SORT_DESC],
                ],
                'marrow' => [
                    'asc'  => ['marrow' => SORT_ASC],
                    'desc' => ['marrow' => SORT_DESC],
                ],
                'because' => [
                    'asc'  => ['because' => SORT_ASC],
                    'desc' => ['because' => SORT_DESC],
                ],
                'becausedate' => [
                    'asc'  => ['becausedate' => SORT_ASC],
                    'desc' => ['becausedate' => SORT_DESC],
                ],
                'personal_id' => [
                    'asc'  => ['personal.name1' => SORT_ASC],
                    'desc' => ['personal.name1' => SORT_DESC],
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'marrowno' => $this->marrowno,
            'mid' => $this->mid,
        ]);

        $query->andFilterWhere(['like', 'code1', $this->code1])
            ->andFilterWhere(['like', 'marrow', $this->marrow])
            ->andFilterWhere(['like', 'because', $this->because])
            ->andFilterWhere(['like', 'becausedate', $this->becausedate])
            ->andFilterWhere(['like', 'mfcode', $this->mfcode])
            ->andFilterWhere(['like', 'mhkdz', $this->mhkdz])
            ->andFilterWhere(['like', 'marrowdate', $this->marrowdate])
            ->andFilterWhere(['like', 'marrowunit', $this->marrowunit])
            ->andFilterWhere(['like', 'othertel', $this->othertel])
            ->andFilterWhere(['like', 'hfp', $this->hfp])
            ->andFilterWhere(['like', 'maddr', $this->maddr])
            ->andFilterWhere(['like', 'mpostcode', $this->mpostcode])
            ->andFilterWhere(['like', 'hmarry', $this->hmarry])
            ->andFilterWhere(['like', 'marrycode', $this->marrycode])
            ->andFilterWhere(['like', 'mem', $this->mem])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'personal.name1', $this->personal_id])
            ->andFilterWhere(['like', 'do_man', $this->do_man]);

        return $dataProvider;
    }
}
