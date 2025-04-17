<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "direction".
 *
 * @property int $id
 * @property string $name_uz
 * @property string $name_ru
 * @property string $name_en
 * @property int $edu_year_id
 * @property int $language_id
 * @property int $edu_year_type_id
 * @property int $edu_year_form_id
 * @property int $edu_duration
 * @property int|null $edu_form_id
 * @property int|null $edu_type_id
 * @property int|null $contract
 * @property string $code
 * @property string|null $course_json
 * @property int|null $oferta
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 *
 * @property DirectionSubject[] $directionSubjects
 * @property EduForm $eduForm
 * @property EduType $eduType
 * @property EduYear $eduYear
 * @property EduYearForm $eduYearForm
 * @property EduYearType $eduYearType
 * @property Languages $language
 */
class Direction extends \yii\db\ActiveRecord
{
    use ResourceTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'direction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz', 'name_ru', 'name_en', 'language_id', 'edu_year_type_id', 'edu_year_form_id', 'code' , 'contract' , 'edu_duration'], 'required'],
            [['edu_year_id', 'language_id', 'edu_year_type_id', 'edu_year_form_id', 'edu_form_id', 'edu_type_id', 'contract', 'oferta', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['name_uz', 'name_ru', 'name_en', 'code', 'course_json'], 'string', 'max' => 255],
            [['edu_duration'], 'number'],
            [['edu_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduForm::class, 'targetAttribute' => ['edu_form_id' => 'id']],
            [['edu_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduType::class, 'targetAttribute' => ['edu_type_id' => 'id']],
            [['edu_year_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYearForm::class, 'targetAttribute' => ['edu_year_form_id' => 'id']],
            [['edu_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYear::class, 'targetAttribute' => ['edu_year_id' => 'id']],
            [['edu_year_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYearType::class, 'targetAttribute' => ['edu_year_type_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::class, 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_uz' => Yii::t('app', 'Name Uz'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_en' => Yii::t('app', 'Name En'),
            'edu_year_id' => Yii::t('app', 'Yil'),
            'edu_duration' => Yii::t('app', 'Davomiylik'),
            'language_id' => Yii::t('app', 'Til'),
            'edu_year_type_id' => Yii::t('app', 'Tur'),
            'edu_year_form_id' => Yii::t('app', 'Shakl'),
            'edu_form_id' => Yii::t('app', 'Edu Form ID'),
            'edu_type_id' => Yii::t('app', 'Edu Type ID'),
            'contract' => Yii::t('app', 'Sum'),
            'code' => Yii::t('app', 'Code'),
            'course_json' => Yii::t('app', 'Course Json'),
            'oferta' => Yii::t('app', 'Oferta'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * Gets query for [[DirectionSubjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDirectionSubjects()
    {
        return $this->hasMany(DirectionSubject::class, ['direction_id' => 'id']);
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
     * Gets query for [[EduType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEduType()
    {
        return $this->hasOne(EduType::class, ['id' => 'edu_type_id']);
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

    /**
     * Gets query for [[EduYearForm]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEduYearForm()
    {
        return $this->hasOne(EduYearForm::class, ['id' => 'edu_year_form_id']);
    }

    /**
     * Gets query for [[EduYearType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEduYearType()
    {
        return $this->hasOne(EduYearType::class, ['id' => 'edu_year_type_id']);
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Languages::class, ['id' => 'language_id']);
    }


    public static function createItem($model , $eduYear)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        $model->edu_year_id = $eduYear->id;

        if (!$model->validate()) {
            $errors[] = $model->simple_errors($model->errors);
        }

        $model->edu_form_id = $model->eduYearForm->edu_form_id;
        $model->edu_type_id = $model->eduYearType->edu_type_id;

        if (!$model->save(false)) {
            $errors[] = ['model' => 'Error saving data'];
        }

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }
}
