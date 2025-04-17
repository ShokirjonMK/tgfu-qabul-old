<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "exam".
 *
 * @property int $id
 * @property int $user_id
 * @property int $student_id
 * @property int $direction_id
 * @property int|null $language_id
 * @property int|null $edu_year_form_id
 * @property int|null $edu_year_type_id
 * @property int|null $edu_type_id
 * @property int|null $edu_form_id
 * @property int|null $start_time
 * @property int|null $finish_time
 * @property float|null $ball
 * @property int|null $exam_count
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $down_time
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 * @property int $correct_type
 * @property int $confirm_date
 * @property float $contract_price
 * @property float $contract_type
 *
 * @property Direction $direction
 * @property EduForm $eduForm
 * @property EduType $eduType
 * @property EduYearForm $eduYearForm
 * @property EduYearType $eduYearType
 * @property ExamSubject[] $examSubjects
 * @property Languages $language
 * @property Student $student
 * @property User $user
 */
class Exam extends \yii\db\ActiveRecord
{
    use ResourceTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exam';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'student_id', 'direction_id'], 'required'],
            [['user_id', 'student_id', 'down_time','direction_id','correct_type', 'confirm_date', 'language_id', 'edu_year_form_id', 'edu_year_type_id', 'edu_type_id', 'edu_form_id', 'start_time', 'finish_time', 'exam_count', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['ball' , 'contract_type' , 'contract_price'], 'number'],
            [['contract_second' , 'contract_third' , 'contract_link'], 'string' , 'max' => 255],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::class, 'targetAttribute' => ['direction_id' => 'id']],
            [['edu_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduForm::class, 'targetAttribute' => ['edu_form_id' => 'id']],
            [['edu_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduType::class, 'targetAttribute' => ['edu_type_id' => 'id']],
            [['edu_year_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYearForm::class, 'targetAttribute' => ['edu_year_form_id' => 'id']],
            [['edu_year_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYearType::class, 'targetAttribute' => ['edu_year_type_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::class, 'targetAttribute' => ['language_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::class, 'targetAttribute' => ['student_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'direction_id' => Yii::t('app', 'Direction ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'edu_year_form_id' => Yii::t('app', 'Edu Year Form ID'),
            'edu_year_type_id' => Yii::t('app', 'Edu Year Type ID'),
            'edu_type_id' => Yii::t('app', 'Edu Type ID'),
            'edu_form_id' => Yii::t('app', 'Edu Form ID'),
            'start_time' => Yii::t('app', 'Start Time'),
            'finish_time' => Yii::t('app', 'Finish Time'),
            'ball' => Yii::t('app', 'Ball'),
            'exam_count' => Yii::t('app', 'Exam Count'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * Gets query for [[Direction]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDirection()
    {
        return $this->hasOne(Direction::class, ['id' => 'direction_id']);
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
     * Gets query for [[ExamSubjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamSubjects()
    {
        return $this->hasMany(ExamSubject::class, ['exam_id' => 'id'])->where(['status' => 1, 'is_deleted' => 0]);
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

    /**
     * Gets query for [[Student]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::class, ['id' => 'student_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


    public static function deleteBall($model)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if (!$model->validate()) {
            $errors[] = $model->simple_errors($model->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        if ($model->status != 3) {
            $errors[] = ['Testni to\'liq yakunlamagan.'];
        } else {
            $model->status = 1;
            $model->start_time = null;
            $model->finish_time = null;
            $model->ball = 0;
            $model->confirm_date = 0;
            $model->save(false);

            $examSubjects = ExamSubject::find()
                ->where([
                    'exam_id' => $model->id,
                    'status' => 1,
                    'is_deleted' => 0
                ])->all();

            ExamStudentQuestions::updateAll(['status' => 0 , 'is_deleted' => 3] , ['exam_id' => $model->id , 'status' => 1, 'is_deleted' => 0]);
            if (count($examSubjects) > 0) {
                foreach ($examSubjects as $examSubject) {
                    if ($examSubject->file_status != 2) {
                        $examSubject->ball = 0;
                        $examSubject->save(false);
                    }
                }
            }
        }

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }


    public function beforeSave($insert)
    {
        if ($insert) {
            $micTime = (int) round(microtime(true) * 1000);
            $startKey = Yii::$app->security->generateRandomString(10);
            $endKey = Yii::$app->security->generateRandomString(12);
            $this->contract_second = '2'.$micTime;
            $this->contract_third = '3'.$micTime;
            $this->contract_link = 'ikQ_'.$startKey.$micTime.$endKey;
        }
        return parent::beforeSave($insert);
    }
}
