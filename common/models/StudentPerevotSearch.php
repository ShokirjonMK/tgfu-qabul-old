<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StudentPerevot;

/**
 * StudentPerevotSearch represents the model behind the search form of `common\models\StudentPerevot`.
 */
class StudentPerevotSearch extends StudentPerevot
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'student_id', 'direction_id', 'file_status', 'contract_type', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'down_time', 'direction_course_id', 'course_id', 'confirm_date'], 'integer'],
            [['file', 'contract_second', 'contract_third', 'contract_link', 'edu_name', 'edu_direction'], 'safe'],
            [['contract_price'], 'number'],
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
    public function search($params)
    {
        $user = \Yii::$app->user->identity;
        $query = StudentPerevot::find()
            ->where(['in' , 'user_id' , User::find()
                ->select('id')
                ->where(['>' , 'step' , 4])
                ->andWhere(['user_role' => 'student'])
                ->andWhere(['cons_id' => $user->cons_id])
            ]);

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
            'user_id' => $this->user_id,
            'student_id' => $this->student_id,
            'direction_id' => $this->direction_id,
            'file_status' => $this->file_status,
            'contract_type' => $this->contract_type,
            'contract_price' => $this->contract_price,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'down_time' => $this->down_time,
            'direction_course_id' => $this->direction_course_id,
            'course_id' => $this->course_id,
            'confirm_date' => $this->confirm_date,
        ]);

        $query->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'contract_second', $this->contract_second])
            ->andFilterWhere(['like', 'contract_third', $this->contract_third])
            ->andFilterWhere(['like', 'contract_link', $this->contract_link])
            ->andFilterWhere(['like', 'edu_name', $this->edu_name])
            ->andFilterWhere(['like', 'edu_direction', $this->edu_direction]);

        return $dataProvider;
    }
}
