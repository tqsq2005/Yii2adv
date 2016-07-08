<?php

namespace common\populac\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\populac\models\MapTable;

/**
 * MapTableSearch represents the model behind the search form about `common\populac\models\MapTable`.
 */
class MapTableSearch extends MapTable
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_num', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['tname', 'cnname', 'memo'], 'safe'],
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
        $query = MapTable::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'order_num' => $this->order_num,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'tname', $this->tname])
            ->andFilterWhere(['like', 'cnname', $this->cnname])
            ->andFilterWhere(['like', 'memo', $this->memo]);

        //默认排序
        $query->orderBy([
            'order_num' => SORT_DESC,
            'tname'     => SORT_ASC
        ]);

        return $dataProvider;
    }
}
