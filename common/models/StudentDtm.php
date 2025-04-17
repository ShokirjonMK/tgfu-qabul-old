<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student_dtm".
 *
 * @property int $id
 * @property int $user_id
 * @property int $student_id
 * @property int $direction_id
 * @property string|null $file
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
class StudentDtm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_dtm';
    }
    public $sms_text;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'student_id', 'direction_id'], 'required'],
            [['user_id', 'student_id', 'direction_id', 'down_time','confirm_date', 'file_status', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['contract_price', 'contract_type'], 'number'],
            [['sms_text'], 'safe'],
            [['file', 'contract_second' , 'contract_third' , 'contract_link'], 'string', 'max' => 255],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::class, 'targetAttribute' => ['direction_id' => 'id']],
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
            'file' => Yii::t('app', 'File'),
            'file_status' => Yii::t('app', 'File Status'),
            'contract_type' => Yii::t('app', 'Contract Type'),
            'contract_price' => Yii::t('app', 'Contract Price'),
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

    public function beforeSave($insert)
    {
        if ($insert) {
            $micTime = (int) round(microtime(true) * 1000);
            $startKey = Yii::$app->security->generateRandomString(10);
            $endKey = Yii::$app->security->generateRandomString(12);
            $this->contract_second = '2'.$micTime;
            $this->contract_third = '3'.$micTime;
            $this->contract_link = 'ikD_'.$startKey.$micTime.$endKey;
        }
        return parent::beforeSave($insert);
    }
}
