<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Personal;

/**
 * PersonSearch represents the model behind the search form about `common\models\Personal`.
 */
class PersonSearch extends Personal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code1', 'name1', 'sex', 'birthdate', 'fcode', 'mz', 'marry', 'marrydate', 'address1', 'hkaddr', 'tel', 'postcode', 'hkxz', 'work1', 'whcd', 'is_dy', 'title', 'zw', 'grous', 'obect1', 'flag', 'unit', 'jobdate', 'ingoingdate', 'memo1', 'lhdate', 'zhdate', 'picture_name', 'onlysign', 'ltunit', 'ltaddr', 'ltman', 'lttel', 'ltpostcode', 'memo', 'cztype', 'carddate', 'examinedate', 'cardcode', 'fzdw', 'feeddate', 'yzdate', 'checkunit', 'incity', 'memo2', 's_date', 'e_date', 'personal_id', 'do_man', 'marrowdate', 'oldunit', 'leavedate', 'checktime', 'audittime'], 'safe'],
            [['childnum', 'selfno', 'logout', 'id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
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
        $query = Personal::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'childnum' => $this->childnum,
            'selfno' => $this->selfno,
            'logout' => $this->logout,
            'id' => $this->id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'code1', $this->code1])
            ->andFilterWhere(['like', 'name1', $this->name1])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'birthdate', $this->birthdate])
            ->andFilterWhere(['like', 'fcode', $this->fcode])
            ->andFilterWhere(['like', 'mz', $this->mz])
            ->andFilterWhere(['like', 'marry', $this->marry])
            ->andFilterWhere(['like', 'marrydate', $this->marrydate])
            ->andFilterWhere(['like', 'address1', $this->address1])
            ->andFilterWhere(['like', 'hkaddr', $this->hkaddr])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'postcode', $this->postcode])
            ->andFilterWhere(['like', 'hkxz', $this->hkxz])
            ->andFilterWhere(['like', 'work1', $this->work1])
            ->andFilterWhere(['like', 'whcd', $this->whcd])
            ->andFilterWhere(['like', 'is_dy', $this->is_dy])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'zw', $this->zw])
            ->andFilterWhere(['like', 'grous', $this->grous])
            ->andFilterWhere(['like', 'obect1', $this->obect1])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'jobdate', $this->jobdate])
            ->andFilterWhere(['like', 'ingoingdate', $this->ingoingdate])
            ->andFilterWhere(['like', 'memo1', $this->memo1])
            ->andFilterWhere(['like', 'lhdate', $this->lhdate])
            ->andFilterWhere(['like', 'zhdate', $this->zhdate])
            ->andFilterWhere(['like', 'picture_name', $this->picture_name])
            ->andFilterWhere(['like', 'onlysign', $this->onlysign])
            ->andFilterWhere(['like', 'ltunit', $this->ltunit])
            ->andFilterWhere(['like', 'ltaddr', $this->ltaddr])
            ->andFilterWhere(['like', 'ltman', $this->ltman])
            ->andFilterWhere(['like', 'lttel', $this->lttel])
            ->andFilterWhere(['like', 'ltpostcode', $this->ltpostcode])
            ->andFilterWhere(['like', 'memo', $this->memo])
            ->andFilterWhere(['like', 'cztype', $this->cztype])
            ->andFilterWhere(['like', 'carddate', $this->carddate])
            ->andFilterWhere(['like', 'examinedate', $this->examinedate])
            ->andFilterWhere(['like', 'cardcode', $this->cardcode])
            ->andFilterWhere(['like', 'fzdw', $this->fzdw])
            ->andFilterWhere(['like', 'feeddate', $this->feeddate])
            ->andFilterWhere(['like', 'yzdate', $this->yzdate])
            ->andFilterWhere(['like', 'checkunit', $this->checkunit])
            ->andFilterWhere(['like', 'incity', $this->incity])
            ->andFilterWhere(['like', 'memo2', $this->memo2])
            ->andFilterWhere(['like', 's_date', $this->s_date])
            ->andFilterWhere(['like', 'e_date', $this->e_date])
            ->andFilterWhere(['like', 'personal_id', $this->personal_id])
            ->andFilterWhere(['like', 'do_man', $this->do_man])
            ->andFilterWhere(['like', 'marrowdate', $this->marrowdate])
            ->andFilterWhere(['like', 'oldunit', $this->oldunit])
            ->andFilterWhere(['like', 'leavedate', $this->leavedate])
            ->andFilterWhere(['like', 'checktime', $this->checktime])
            ->andFilterWhere(['like', 'audittime', $this->audittime]);

        return $dataProvider;
    }
}
