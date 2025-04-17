<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Exam;

/**
 * ExamSearch represents the model behind the search form of `common\models\Exam`.
 */
class ExamSearch extends Exam
{
    public $first_name;
    public $last_name;
    public $middle_name;
    public $username;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'student_id', 'direction_id', 'language_id', 'edu_year_form_id', 'edu_year_type_id', 'edu_type_id', 'edu_form_id', 'start_time', 'finish_time', 'exam_count', 'status', 'created_at', 'updated_at', 'is_deleted', 'down_time', 'correct_type', 'confirm_date', 'updated_by', 'created_by'], 'integer'],
            [['ball', 'contract_type', 'contract_price'], 'number'],
            [['contract_second', 'contract_third', 'contract_link'], 'safe'],
            [['first_name', 'last_name', 'middle_name','username'], 'string'],
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
        $query = Exam::find()
            ->with(['student'])
            ->join('LEFT JOIN', 'student', 'exam.student_id = student.id')
            ->where(['in' , 'exam.user_id' , User::find()
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
            'language_id' => $this->language_id,
            'edu_year_form_id' => $this->edu_year_form_id,
            'edu_year_type_id' => $this->edu_year_type_id,
            'edu_type_id' => $this->edu_type_id,
            'edu_form_id' => $this->edu_form_id,
            'start_time' => $this->start_time,
            'finish_time' => $this->finish_time,
            'ball' => $this->ball,
            'exam_count' => $this->exam_count,
            'exam.status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_deleted' => $this->is_deleted,
            'contract_type' => $this->contract_type,
            'contract_price' => $this->contract_price,
            'down_time' => $this->down_time,
            'correct_type' => $this->correct_type,
            'confirm_date' => $this->confirm_date,
            'updated_by' => $this->updated_by,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'contract_second', $this->contract_second])
            ->andFilterWhere(['like', 'contract_third', $this->contract_third])
            ->andFilterWhere(['like', 'contract_link', $this->contract_link])
            ->andFilterWhere(['like', 'student.first_name', $this->first_name])
            ->andFilterWhere(['like', 'student.last_name', $this->last_name])
            ->andFilterWhere(['like', 'student.middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'student.username', $this->username]);

        return $dataProvider;
    }
}
