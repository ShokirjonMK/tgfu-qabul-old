<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Employee;

/**
 * EmployeeSearch represents the model behind the search form of `common\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    /**
     * {@inheritdoc}
     */

    public $cons_id;
    public $role;

    public function rules()
    {
        return [
            [['id', 'user_id', 'gender', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted' , 'cons_id'], 'integer'],
            [['first_name', 'last_name', 'middle_name', 'phone', 'brithday', 'image', 'adress', 'password', 'role'], 'safe'],
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
    public function search($params , $cons , $roles , $user, $role)
    {
        $query = Employee::find();
        if ($role->name == 'admin') {
            $query->andWhere(['in' , 'user_id' , User::find()
                ->select('id')
                ->where([
                    'cons_id' => $user->cons_id,
                ])
                ->andWhere(['not in' , 'user_role' , ['supper_admin' , 'student']])
            ]);
        }

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

        if ($role->name == 'admin') {
            if ($this->cons_id != null) {
                $this->cons_id = $user->cons_id;
            }
            if ($this->role != null) {
                if (!($this->role == 'admin' || $this->role == 'moderator')) {
                    $this->role = null;
                }
            }
        }

        if ($role->name == 'supper_admin') {
            if ($this->cons_id != null) {
                $query->andFilterWhere([
                    'in' , 'user_id', User::find()
                        ->select('id')
                        ->where([
                            'cons_id' => $this->cons_id,
                        ])
                        ->andWhere(['not in' , 'user_role' , 'student'])
                ]);
            }
        }

        if ($this->role != null) {
            $query->andFilterWhere([
                'in' , 'user_id', User::find()
                    ->select('id')
                    ->where(['user_role' => $this->role])
            ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'brithday', $this->brithday])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $dataProvider;
    }
}
