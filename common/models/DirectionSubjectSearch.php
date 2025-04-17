<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DirectionSubject;

/**
 * DirectionSubjectSearch represents the model behind the search form of `common\models\DirectionSubject`.
 */
class DirectionSubjectSearch extends DirectionSubject
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'direction_id', 'subject_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['ball', 'question_count'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function search($params , $direction)
    {
        $query = DirectionSubject::find()
            ->where(['direction_id' => $direction->id , 'is_deleted' => 0])
            ->orderBy('ball desc');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'direction_id' => $this->direction_id,
            'subject_id' => $this->subject_id,
            'ball' => $this->ball,
            'question_count' => $this->question_count,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
        ]);

        return $dataProvider;
    }
}
