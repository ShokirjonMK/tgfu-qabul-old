<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "direction_course".
 *
 * @property int $id
 * @property int $direction_id
 * @property int $course_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 *
 * @property Course $course
 * @property Direction $direction
 */
class DirectionCourse extends \yii\db\ActiveRecord
{
    use ResourceTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'direction_course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id'], 'required'],
            [['direction_id', 'course_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id']],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::class, 'targetAttribute' => ['direction_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'direction_id' => Yii::t('app', 'Direction ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * Gets query for [[Course]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::class, ['id' => 'course_id']);
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


    public static function createItem($model , $direction)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        $model->direction_id = $direction->id;

        if ($direction->edu_type_id != 2) {
            $errors[] = ['Bu turga boshqich qo\'shilmaydi!'];
        } else {
            if (!$model->validate()) {
                $errors[] = $model->simple_errors($model->errors);
            }

            if (!$model->save(false)) {
                $errors[] = ['model' => 'Error saving data'];
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
            $this->created_by = Yii::$app->user->identity->id;
        } else {
            $this->updated_by = Yii::$app->user->identity->id;
        }

        return parent::beforeSave($insert);
    }

}
