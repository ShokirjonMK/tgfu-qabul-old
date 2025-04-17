<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "exam_subject".
 *
 * @property int $id
 * @property int $user_id
 * @property int $student_id
 * @property int $exam_id
 * @property int $direction_id
 * @property int $direction_subject_id
 * @property int $subject_id
 * @property int|null $language_id
 * @property int|null $edu_year_form_id
 * @property int|null $edu_year_type_id
 * @property int|null $edu_type_id
 * @property int|null $edu_form_id
 * @property string|null $file
 * @property int|null $file_status
 * @property float|null $ball
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 *
 * @property Direction $direction
 * @property DirectionSubject $directionSubject
 * @property EduForm $eduForm
 * @property EduType $eduType
 * @property EduYearForm $eduYearForm
 * @property EduYearType $eduYearType
 * @property Exam $exam
 * @property Languages $language
 * @property Student $student
 * @property Subjects $subject
 * @property User $user
 * @property ExamStudentQuestions $studentQuestions
 * @property ExamStudentQuestions $questions
 */
class ExamSubject extends \yii\db\ActiveRecord
{
    use ResourceTrait;

    public $sms_text;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exam_subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'student_id', 'exam_id', 'direction_id', 'direction_subject_id', 'subject_id'], 'required'],
            [['user_id', 'student_id', 'exam_id', 'direction_id', 'direction_subject_id', 'subject_id', 'language_id', 'edu_year_form_id', 'edu_year_type_id', 'edu_type_id', 'edu_form_id', 'file_status', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['ball'], 'number'],
            [['file'], 'string', 'max' => 255],
            [['sms_text'], 'safe'],
            [['direction_subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => DirectionSubject::class, 'targetAttribute' => ['direction_subject_id' => 'id']],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::class, 'targetAttribute' => ['direction_id' => 'id']],
            [['edu_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduForm::class, 'targetAttribute' => ['edu_form_id' => 'id']],
            [['edu_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduType::class, 'targetAttribute' => ['edu_type_id' => 'id']],
            [['edu_year_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYearForm::class, 'targetAttribute' => ['edu_year_form_id' => 'id']],
            [['edu_year_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYearType::class, 'targetAttribute' => ['edu_year_type_id' => 'id']],
            [['exam_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exam::class, 'targetAttribute' => ['exam_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::class, 'targetAttribute' => ['language_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::class, 'targetAttribute' => ['student_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::class, 'targetAttribute' => ['subject_id' => 'id']],
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
            'exam_id' => Yii::t('app', 'Exam ID'),
            'direction_id' => Yii::t('app', 'Direction ID'),
            'direction_subject_id' => Yii::t('app', 'Direction Subject ID'),
            'subject_id' => Yii::t('app', 'Subject ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'edu_year_form_id' => Yii::t('app', 'Edu Year Form ID'),
            'edu_year_type_id' => Yii::t('app', 'Edu Year Type ID'),
            'edu_type_id' => Yii::t('app', 'Edu Type ID'),
            'edu_form_id' => Yii::t('app', 'Edu Form ID'),
            'file' => Yii::t('app', 'File'),
            'file_status' => Yii::t('app', 'File Status'),
            'ball' => Yii::t('app', 'Ball'),
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
     * Gets query for [[DirectionSubject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDirectionSubject()
    {
        return $this->hasOne(DirectionSubject::class, ['id' => 'direction_subject_id']);
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

    public function getStudentQuestions()
    {
        $user = Yii::$app->user->identity;
        return $this->hasMany(ExamStudentQuestions::class, ['exam_subject_id' => 'id'])
            ->where(['user_id' => $user->id , 'status' => 1, 'is_deleted' => 0]);
    }

    public function getQuestions()
    {
        return $this->hasMany(ExamStudentQuestions::class, ['exam_subject_id' => 'id'])
            ->where(['status' => 1, 'is_deleted' => 0]);
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
     * Gets query for [[Exam]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExam()
    {
        return $this->hasOne(Exam::class, ['id' => 'exam_id']);
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
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subjects::class, ['id' => 'subject_id']);
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


    public static function checkItem($model)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if ($model->status == 0 || $model->is_deleted == 1) {
            $errors[] = ['Ariza holadi bekor qilindi.'];
        }
        $phone = $model->student->user->username;

        if ($model->sms_text == null) {
            $errors[] = ['SMS matn yuborilishi shart!!!'];
        }

        if ($model->file_status == 2) {
            $model->ball = $model->directionSubject->ball * $model->directionSubject->question_count;
        } else {
            $model->ball = 0;
        }

        if (count($errors) == 0) {
            $model->save(false);
            $exam = $model->exam;
            if ($exam->status == 3) {
                $examSubjects = $exam->examSubjects;
                if ($examSubjects) {
                    $ball = 0;
                    foreach ($examSubjects as $examSubject) {
                        $ball = $ball + $examSubject->ball;
                    }
                    $exam->ball = $ball;
                    $exam->save(false);
                }
            }
            if ($model->file_status == 2) {
                $text = $model->sms_text;
                Message::sendedSms($phone , $text);
            } elseif ($model->file_status == 3) {
                $text = $model->sms_text;
                Message::sendedSms($phone , $text);
            } else {
                $errors[] = ['Status xato yuborildi'];
                $transaction->rollBack();
                return ['is_ok' => false , 'errors' => $errors];
            }
            $transaction->commit();
            return ['is_ok' => true];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }


}
