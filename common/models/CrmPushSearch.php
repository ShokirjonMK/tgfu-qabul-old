<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CrmPush;

/**
 * CrmPushSearch represents the model behind the search form of `common\models\CrmPush`.
 */
class CrmPushSearch extends CrmPush
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'type', 'lead_id', 'lead_status', 'data_save_time', 'push_time', 'status', 'is_deleted'], 'integer'],
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
        $query = CrmPush::find()->orderBy('data_save_time asc');

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
            'student_id' => $this->student_id,
            'type' => $this->type,
            'lead_id' => $this->lead_id,
            'lead_status' => $this->lead_status,
            'data_save_time' => $this->data_save_time,
            'push_time' => $this->push_time,
            'status' => $this->status,
            'is_deleted' => $this->is_deleted,
        ]);

        return $dataProvider;
    }
}
