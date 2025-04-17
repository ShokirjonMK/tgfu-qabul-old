<?php

namespace common\models;

use common\models\Student;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * StudentSearch represents the model behind the search form of `common\models\Student`.
 */
class StudentSearch extends Student
{
    public $full_name;

    public $group_id;

    public $subject_id;

    public $step;
    public $start_date;
    public $end_date;


    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['id','user_id', 'gender','language_id', 'edu_form_id','edu_year_form_id', 'direction_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted' , 'step' , 'filial_id'], 'integer'],
            [['username'], 'string' , 'max' => 255],
            [['full_name','first_name', 'last_name','passport_number', 'passport_serial', 'middle_name', 'recorded_date', 'start_date', 'end_date', 'adress',  'password', 'exam_type'], 'safe'],
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

    public function search($params, $edu_type)
    {
        $user = Yii::$app->user->identity;
        $query = Student::find()
            ->where(['edu_year_type_id' => $edu_type->id])
            ->andWhere(['in' , 'user_id' , User::find()
                ->select('id')
                ->where(['step' => 5])
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

        if ($this->status != null) {
            if ($edu_type->edu_type_id == 1) {
                if ($this->status <= 3) {
                    $query->andWhere(
                        ['in' , 'id' ,
                            Exam::find()->select('student_id')
                                ->where([
                                    'edu_year_type_id' => $edu_type->id,
                                    'status' => $this->status,
                                ])
                        ]);
                } elseif ($this->status == 4) {
                    $query->andWhere(
                        ['in' , 'id' ,
                            Exam::find()->select('student_id')
                                ->where([
                                    'edu_year_type_id' => $edu_type->id,
                                    'status' => 3,
                                ])->andWhere(['>' , 'down_time' , 0])
                        ]);
                } elseif ($this->status == 5) {
                    $query->andWhere(
                        ['in' , 'id' ,
                            Exam::find()->select('student_id')
                                ->where([
                                    'edu_year_type_id' => $edu_type->id,
                                    'status' => 3,
                                    'down_time' => null
                                ])
                        ]);
                }
            } elseif ($edu_type->edu_type_id == 2) {
                $query->andWhere(
                    ['in' , 'id' ,
                        StudentPerevot::find()->select('student_id')
                            ->where([
                                'file_status' => $this->status,
                                'status' => 1,
                                'is_deleted' => 0,
                            ])
                    ]);
            } elseif ($edu_type->edu_type_id == 3) {
                $query->andWhere(
                    ['in' , 'id' ,
                        StudentDtm::find()->select('student_id')
                            ->where([
                                'file_status' => $this->status,
                                'status' => 1,
                                'is_deleted' => 0,
                            ])
                    ]);
            } elseif ($edu_type->edu_type_id == 4) {
                $query->andWhere(
                    ['in' , 'id' ,
                        StudentMagistr::find()->select('student_id')
                            ->where([
                                'file_status' => $this->status,
                                'status' => 1,
                                'is_deleted' => 0,
                            ])
                    ]);
            }
        }

        if ($this->start_date != null) {
            $query->andWhere(
                ['in' , 'user_id',
                    User::find()->select('id')
                        ->where(['>=' , 'created_at' , strtotime($this->start_date)])
                ]);
        }
        if ($this->end_date != null) {
            $query->andWhere(
                ['in' , 'user_id' ,
                    User::find()->select('id')
                        ->where(['<=' , 'created_at' , strtotime($this->end_date)])
                ]);
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'language_id' => $this->language_id,
            'edu_year_form_id' => $this->edu_year_form_id,
            'direction_id' => $this->direction_id,
            'created_at' => $this->created_at,
            'exam_type' => $this->exam_type,
            'filial_id' => $this->filial_id,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
        ]);

        if ($this->username != '+998 (__) ___-__-__') {
            $query->andFilterWhere(['like', 'username', $this->username]);
        }

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'passport_serial', $this->passport_serial])
            ->andFilterWhere(['like', 'passport_number', $this->passport_number])
            ->andFilterWhere(['like', 'first_name', $this->full_name])
            ->orFilterWhere(['like', 'last_name', $this->full_name])
            ->orFilterWhere(['like', 'middle_name', $this->full_name])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'password', $this->password]);
        return $dataProvider;
    }

    public function step($params)
    {
        $user = Yii::$app->user->identity;
        $query = Student::find()
            ->andWhere(['in' , 'user_id' , User::find()
                ->select('id')
                ->where(['<' , 'step' , 5])
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

        if ($this->start_date != null) {
            $query->andWhere(
                ['in' , 'user_id',
                    User::find()->select('id')
                        ->where(['>=' , 'created_at' , strtotime($this->start_date)])
                ]);
        }
        if ($this->end_date != null) {
            $query->andWhere(
                ['in' , 'user_id' ,
                    User::find()->select('id')
                        ->where(['<=' , 'created_at' , strtotime($this->end_date)])
                ]);
        }
        if ($this->status != null) {
            $query->andWhere(
                ['in' , 'user_id' ,
                    User::find()->select('id')
                        ->where([
                            'status' => $this->status,
                        ])
                ]);
        }

        if ($this->step != null) {
            $query->andWhere(
                ['in' , 'user_id' ,
                    User::find()->select('id')
                        ->where([
                            'step' => $this->step,
                        ])
                ]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'language_id' => $this->language_id,
            'filial_id' => $this->filial_id,
            'edu_year_form_id' => $this->edu_year_form_id,
            'direction_id' => $this->direction_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
        ]);

        if ($this->username != '+998 (__) ___-__-__') {
            $query->andFilterWhere(['like', 'username', $this->username]);
        }

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'passport_serial', $this->passport_serial])
            ->andFilterWhere(['like', 'passport_number', $this->passport_number])
            ->andFilterWhere(['like', 'first_name', $this->full_name])
            ->orFilterWhere(['like', 'last_name', $this->full_name])
            ->orFilterWhere(['like', 'middle_name', $this->full_name])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'password', $this->password]);
        return $dataProvider;
    }


    public function all($params)
    {
        $query = Student::find()
            ->andWhere(['in', 'user_id', User::find()
                ->select('id')
                ->andWhere(['user_role' => 'student'])
                ->andWhere(['status' => 10])])
            ->andWhere([
                'or',
                ['exists', (new \yii\db\Query())
                    ->from('exam')
                    ->where('exam.student_id = student.id')
                    ->andWhere(['exam.status' => 3, 'exam.is_deleted' => 0])],
                ['exists', (new \yii\db\Query())
                    ->from('student_perevot')
                    ->where('student_perevot.student_id = student.id')
                    ->andWhere(['student_perevot.status' => 1, 'student_perevot.file_status' => 2, 'student_perevot.is_deleted' => 0])],
                ['exists', (new \yii\db\Query())
                    ->from('student_dtm')
                    ->where('student_dtm.student_id = student.id')
                    ->andWhere(['student_dtm.status' => 1, 'student_dtm.file_status' => 2, 'student_dtm.is_deleted' => 0])],
                ['exists', (new \yii\db\Query())
                    ->from('student_magistr')
                    ->where('student_magistr.student_id = student.id')
                    ->andWhere(['student_magistr.status' => 1, 'student_magistr.file_status' => 2, 'student_magistr.is_deleted' => 0])],
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'language_id' => $this->language_id,
            'edu_year_form_id' => $this->edu_year_form_id,
            'direction_id' => $this->direction_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
        ]);

        if ($this->username != '+998 (__) ___-__-__') {
            $query->andFilterWhere(['like', 'username', $this->username]);
        }

        if ($this->cons_id != null) {
            $query->andWhere(['in' , 'user_id' , User::find()->select('id')->where(['cons_id' => $this->cons_id])]);
        }

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'passport_serial', $this->passport_serial])
            ->andFilterWhere(['like', 'passport_number', $this->passport_number])
            ->andFilterWhere(['like', 'first_name', $this->full_name])
            ->orFilterWhere(['like', 'last_name', $this->full_name])
            ->orFilterWhere(['like', 'middle_name', $this->full_name])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $dataProvider;
    }

}
