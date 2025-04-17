<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "student_perevot".
 *
 * @property int $id
 * @property int $user_id
 * @property int $student_id
 * @property int $direction_id
 * @property int|null $direction_course_id
 * @property int|null $course_id
 * @property string|null $file
 * @property string|null $edu_direction
 * @property string|null $edu_name
 * @property int|null $file_status
 * @property int|null $contract_type
 * @property float|null $contract_price
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $down_time
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 * @property int $confirm_date
 *
 * @property Direction $direction
 * @property Student $student
 * @property User $user
 */
class StudentPerevot extends \yii\db\ActiveRecord
{
    const CONFIRM = 2;
    const NO_CONFIRM = 3;

    public $sms_text;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_perevot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'student_id', 'direction_id'], 'required'],
            [['user_id', 'student_id', 'direction_id' , 'confirm_date', 'direction_course_id', 'course_id', 'down_time', 'file_status', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['contract_price', 'contract_type'], 'number'],
            [['file' , 'contract_second' , 'contract_third' , 'contract_link' , 'edu_direction' , 'edu_name'], 'string', 'max' => 255],
            [['sms_text'], 'safe'],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::class, 'targetAttribute' => ['direction_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::class, 'targetAttribute' => ['student_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['direction_course_id'], 'exist', 'skipOnError' => true, 'targetClass' => DirectionCourse::class, 'targetAttribute' => ['direction_course_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id']],
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
            'file' => Yii::t('app', 'File'),
            'file_status' => Yii::t('app', 'File Status'),
            'contract_type' => Yii::t('app', 'Contract Type'),
            'contract_price' => Yii::t('app', 'Contract Price'),
            'sms_' => Yii::t('app', 'Contract Price'),
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

    public static function checkItem($model)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if ($model->status == 0 || $model->is_deleted == 1) {
            $errors[] = ['Ariza holadi bekor qilindi.'];
        }

        if (!($model->file_status == 1 || $model->file_status == 2 || $model->file_status == 3)) {
            $errors[] = ['Status ERRORS!!!'];
        }

        $direction = $model->direction;
        if ($direction->oferta == 1) {
            $oferta = StudentOferta::findOne([
                'direction_id' => $direction->id,
                'student_id' => $model->student_id,
                'status' => 1,
                'is_deleted' => 0
            ]);
            if ($oferta) {
                if ($oferta->file_status != 2) {
                    $errors[] = ['Oferta tasdiqlanmagan'];
                }
            } else {
                $errors[] = ['Oferta ERRORS!!!'];
            }
        }

        $phone = $model->student->user->username;

        if ($model->sms_text == null) {
            $errors[] = ['SMS matn yuborilishi shart!!!'];
        }

        if (count($errors) == 0) {
            $model->save(false);
            if ($model->file_status == self::CONFIRM) {
                $text = $model->sms_text;
                Message::sendedSms($phone , $text);
                $model->confirm_date = time();
                $model->contract_price = $model->contract_type * $model->direction->contract;
                $model->save(false);
            } elseif ($model->file_status == self::NO_CONFIRM) {
                $text = $model->sms_text;
                Message::sendedSms($phone , $text);
            }
            $transaction->commit();
            return ['is_ok' => true];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }


    public static function std($students)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        $exams = Exam::find()
            ->where([
                'status' => 3,
            ])->all();

        if (count($exams) > 0) {
            foreach ($exams as $exam) {
                if ($exam->confirm_date == 0) {
                    if ($exam->updated_at != null) {
                        $exam->confirm_date = $exam->updated_at;
                    } else {
                        $exam->confirm_date = time();
                    }
                    $exam->save(false);
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
            $this->contract_link = 'ikP_'.$startKey.$micTime.$endKey;
        }
        return parent::beforeSave($insert);
    }
}
