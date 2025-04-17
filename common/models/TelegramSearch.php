<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Telegram;

/**
 * TelegramSearch represents the model behind the search form of `common\models\Telegram`.
 */
class TelegramSearch extends Telegram
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'step', 'lang_id', 'gender', 'edu_year_type_id', 'edu_year_form_id', 'direction_id', 'language_id', 'direction_course_id', 'exam_type', 'is_deleted', 'bot_status'], 'integer'],
            [['chat_id', 'first_name', 'last_name', 'middle_name', 'phone', 'passport_serial', 'passport_number', 'passport_pin', 'birthday', 'passport_issued_date', 'passport_given_date', 'passport_given_by', 'edu_name', 'edu_direction'], 'safe'],
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
        $query = Telegram::find()->where(['is_deleted' => 0]);

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

        if ($this->phone != null) {
            $this->phone = preg_replace('/[^\d+]/', '', $this->phone);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'step' => $this->step,
            'lang_id' => $this->lang_id,
            'gender' => $this->gender,
            'edu_year_type_id' => $this->edu_year_type_id,
            'edu_year_form_id' => $this->edu_year_form_id,
            'direction_id' => $this->direction_id,
            'language_id' => $this->language_id,
            'direction_course_id' => $this->direction_course_id,
            'exam_type' => $this->exam_type,
            'is_deleted' => $this->is_deleted,
            'bot_status' => $this->bot_status,
        ]);

        $query->andFilterWhere(['like', 'chat_id', $this->chat_id])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'passport_serial', $this->passport_serial])
            ->andFilterWhere(['like', 'passport_number', $this->passport_number])
            ->andFilterWhere(['like', 'passport_pin', $this->passport_pin])
            ->andFilterWhere(['like', 'birthday', $this->birthday])
            ->andFilterWhere(['like', 'passport_issued_date', $this->passport_issued_date])
            ->andFilterWhere(['like', 'passport_given_date', $this->passport_given_date])
            ->andFilterWhere(['like', 'passport_given_by', $this->passport_given_by])
            ->andFilterWhere(['like', 'edu_name', $this->edu_name])
            ->andFilterWhere(['like', 'edu_direction', $this->edu_direction]);

        return $dataProvider;
    }
}
