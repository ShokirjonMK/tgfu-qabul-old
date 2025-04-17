<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $middle_name
 * @property string|null $student_phone
 * @property string|null $adress
 * @property string|null $username
 * @property string|null $password
 * @property int|null $gender
 * @property string|null $birthday
 * @property string|null $passport_number
 * @property string|null $passport_serial
 * @property string|null $passport_pin
 * @property string|null $passport_issued_date
 * @property string|null $passport_given_date
 * @property string|null $passport_given_by
 * @property int|null $direction_id
 * @property int|null $language_id
 * @property int|null $edu_year_form_id
 * @property int|null $edu_year_type_id
 * @property int|null $edu_form_id
 * @property int|null $direction_course_id
 * @property int|null $course_id
 * @property int|null $edu_type_id
 * @property int|null $filial_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 * @property string|null $lead_id
 * @property string|null $pipeline_id
 * @property string|null $status_id
 *
 * @property User $user
 * @property EduYearType $eduYearType
 * @property Languages $language
 * @property  $eduStatus
 * @property  $filial
 */
class Student extends \yii\db\ActiveRecord
{
    use ResourceTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id',
                'direction_id',
                'filial_id',
                'language_id',
                'edu_year_form_id',
                'edu_year_type_id',
                'edu_form_id',
                'edu_type_id',
                'direction_course_id',
                'course_id',
                'exam_type',
                'gender', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['adress'], 'string'],
            [['birthday'], 'safe'],
            [['first_name', 'last_name', 'middle_name', 'username', 'password', 'passport_number', 'passport_serial', 'passport_pin', 'passport_issued_date', 'passport_given_date', 'passport_given_by'], 'string', 'max' => 255],
            [['student_phone'], 'string', 'max' => 100],
            [['edu_name' , 'edu_direction' , 'lead_id' , 'pipeline_id' , 'status_id'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['edu_year_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYearType::class, 'targetAttribute' => ['edu_year_type_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id']],
            [['direction_course_id'], 'exist', 'skipOnError' => true, 'targetClass' => DirectionCourse::class, 'targetAttribute' => ['direction_course_id' => 'id']],
            [['edu_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduType::class, 'targetAttribute' => ['edu_type_id' => 'id']],
            [['edu_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduForm::class, 'targetAttribute' => ['edu_form_id' => 'id']],
            [['edu_year_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYearForm::class, 'targetAttribute' => ['edu_year_form_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::class, 'targetAttribute' => ['language_id' => 'id']],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::class, 'targetAttribute' => ['direction_id' => 'id']],
            [['filial_id'], 'exist', 'skipOnError' => true, 'targetClass' => Filial::class, 'targetAttribute' => ['filial_id' => 'id']],
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
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'student_phone' => Yii::t('app', 'Student Phone'),
            'adress' => Yii::t('app', 'Adress'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'gender' => Yii::t('app', 'Gender'),
            'birthday' => Yii::t('app', 'Birthday'),
            'passport_number' => Yii::t('app', 'Passport Number'),
            'passport_serial' => Yii::t('app', 'Passport Serial'),
            'passport_pin' => Yii::t('app', 'Passport Pin'),
            'passport_issued_date' => Yii::t('app', 'Passport Issued Date'),
            'passport_given_date' => Yii::t('app', 'Passport Given Date'),
            'passport_given_by' => Yii::t('app', 'Passport Given By'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
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

    public function getEduYearType()
    {
        return $this->hasOne(EduYearType::class, ['id' => 'edu_year_type_id']);
    }
    public function getEduType()
    {
        return $this->hasOne(EduType::class, ['id' => 'edu_type_id']);
    }

    public function getDirection()
    {
        return $this->hasOne(Direction::class, ['id' => 'direction_id']);
    }

    public function getFilial()
    {
        return $this->hasOne(Filial::class, ['id' => 'filial_id']);
    }

    public function getDirectionCourse()
    {
        return $this->hasOne(DirectionCourse::class, ['id' => 'direction_course_id']);
    }

    public function getEduYearForm()
    {
        return $this->hasOne(EduYearForm::class, ['id' => 'edu_year_form_id']);
    }
    public function getEduForm()
    {
        return $this->hasOne(EduForm::class, ['id' => 'edu_form_id']);
    }

    public function getLanguage()
    {
        return $this->hasOne(Languages::class, ['id' => 'language_id']);
    }

    public function getEduStatus()
    {
        if ($this->edu_type_id == 1) {
            $eduExam = Exam::findOne([
                'student_id' => $this->id,
                'direction_id' => $this->direction_id,
                'is_deleted' => 0
            ]);
            if ($eduExam) {
                if ($eduExam->status == 0) {
                    return "<div class='badge-table-div danger'><span>Bekor qilindi</span></div>";
                } elseif ($eduExam->status == 1) {
                    return "<div class='badge-table-div active'><span>Test ishlamagan</span></div>";
                } elseif ($eduExam->status == 2) {
                    return "<div class='badge-table-div active'><span>Testda</span></div>";
                } elseif ($eduExam->status == 3) {
                    if ($eduExam->down_time != null) {
                        return "<div class='badge-table-div active'><span>Yakunlab shartnoma oldi</span></div>";
                    } else {
                        return "<div class='badge-table-div active'><span>Yakunlab shartnoma olmadi</span></div>";
                    }
                }
            }
        } elseif ($this->edu_type_id == 2) {
            $perevot = StudentPerevot::findOne([
                'student_id' => $this->id,
                'direction_id' => $this->direction_id,
                'status' => 1,
                'is_deleted' => 0
            ]);
            if ($perevot) {
                if ($perevot->file_status == 0) {
                    return "<div class='badge-table-div danger'><span>Yuborilmagan</span></div>";
                } elseif ($perevot->file_status == 1) {
                    return "<div class='badge-table-div active'><span>Kelib tushdi</span></div>";
                } elseif ($perevot->file_status == 2) {
                    return "<div class='badge-table-div active'><span>Tasdiqlandi</span></div>";
                } elseif ($perevot->file_status == 3) {
                    return "<div class='badge-table-div active'><span>Bekor qilindi</span></div>";
                }
            }
        } elseif ($this->edu_type_id == 3) {
            $perevot = StudentDtm::findOne([
                'student_id' => $this->id,
                'direction_id' => $this->direction_id,
                'status' => 1,
                'is_deleted' => 0
            ]);
            if ($perevot) {
                if ($perevot->file_status == 0) {
                    return "<div class='badge-table-div danger'><span>Yuborilmagan</span></div>";
                } elseif ($perevot->file_status == 1) {
                    return "<div class='badge-table-div active'><span>Kelib tushdi</span></div>";
                } elseif ($perevot->file_status == 2) {
                    return "<div class='badge-table-div active'><span>Tasdiqlandi</span></div>";
                } elseif ($perevot->file_status == 3) {
                    return "<div class='badge-table-div active'><span>Bekor qilindi</span></div>";
                }
            }
        } elseif ($this->edu_type_id == 4) {
            $perevot = StudentMagistr::findOne([
                'student_id' => $this->id,
                'direction_id' => $this->direction_id,
                'status' => 1,
                'is_deleted' => 0
            ]);
            if ($perevot) {
                if ($perevot->file_status == 0) {
                    return "<div class='badge-table-div danger'><span>Yuborilmagan</span></div>";
                } elseif ($perevot->file_status == 1) {
                    return "<div class='badge-table-div active'><span>Kelib tushdi</span></div>";
                } elseif ($perevot->file_status == 2) {
                    return "<div class='badge-table-div active'><span>Tasdiqlandi</span></div>";
                } elseif ($perevot->file_status == 3) {
                    return "<div class='badge-table-div active'><span>Bekor qilindi</span></div>";
                }
            }
        }
        return "-----";
    }
}
