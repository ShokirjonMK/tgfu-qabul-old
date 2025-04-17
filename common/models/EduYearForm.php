<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "edu_year_form".
 *
 * @property int $id
 * @property int $edu_year_id
 * @property int $edu_form_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 *
 * @property EduForm $eduForm
 * @property EduYear $eduYear
 */
class EduYearForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_year_form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edu_year_id', 'edu_form_id'], 'required'],
            [['edu_year_id', 'edu_form_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['edu_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduForm::class, 'targetAttribute' => ['edu_form_id' => 'id']],
            [['edu_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYear::class, 'targetAttribute' => ['edu_year_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'edu_year_id' => Yii::t('app', 'Edu Year ID'),
            'edu_form_id' => Yii::t('app', 'Edu Form ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * Gets query for [[EduForm]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEduForm()
    {
        return $this->hasOne(EduForm::class, ['id' => 'edu_form_id']);
    }

    /**
     * Gets query for [[EduYear]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEduYear()
    {
        return $this->hasOne(EduYear::class, ['id' => 'edu_year_id']);
    }

    public static function getEduFormName($eduYear)
    {
        $eduYearForms = EduYearForm::find()->with('eduForm')->where(['edu_year_id' => $eduYear->id,'is_deleted' => 0 , 'status' => 1])->all();
        $data = [];
        $lang = Yii::$app->language;
        if (count($eduYearForms) > 0) {
            foreach ($eduYearForms as $eduYearForm) {
                $data[$eduYearForm->id] = $eduYearForm->eduForm['name_'.$lang];
            }
        }
        return $data;
    }
}
