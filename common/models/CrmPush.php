<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "crm_push".
 *
 * @property int $id
 * @property int $student_id
 * @property int $type
 * @property int|null $lead_id
 * @property int|null $lead_status
 * @property int|null $data_save_time
 * @property int|null $push_time
 * @property int|null $status
 * @property int|null $is_deleted
 */
class CrmPush extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_push';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'type'], 'required'],
            [['student_id', 'type', 'lead_id', 'lead_status', 'data_save_time', 'push_time', 'status', 'is_deleted'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'type' => Yii::t('app', 'Type'),
            'lead_id' => Yii::t('app', 'Lead ID'),
            'lead_status' => Yii::t('app', 'Lead Status'),
            'data_save_time' => Yii::t('app', 'Data Save Time'),
            'push_time' => Yii::t('app', 'Push Time'),
            'status' => Yii::t('app', 'Status'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }
}
