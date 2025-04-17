<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "direction_subject".
 *
 * @property int $id
 * @property int $direction_id
 * @property int $subject_id
 * @property float $ball
 * @property float $question_count
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 *
 * @property Direction $direction
 * @property Subjects $subject
 */
class DirectionSubject extends \yii\db\ActiveRecord
{
    use ResourceTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'direction_subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_id', 'ball', 'question_count'], 'required'],
            [['direction_id', 'subject_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['ball', 'question_count'], 'number'],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::class, 'targetAttribute' => ['direction_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::class, 'targetAttribute' => ['subject_id' => 'id']],
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
            'subject_id' => Yii::t('app', 'Fan'),
            'ball' => Yii::t('app', 'Ball'),
            'question_count' => Yii::t('app', 'Savollar soni'),
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
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subjects::class, ['id' => 'subject_id']);
    }

    public static function createItem($model , $direction)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        $model->direction_id = $direction->id;

        if (!$model->validate()) {
            $errors[] = $model->simple_errors($model->errors);
        }

        $subject = Subjects::findOne([
            'id' => $model->subject_id,
            'language_id' => $direction->language_id,
            'status' => 1,
            'is_deleted' => 0
        ]);
        if (!$subject) {
            $errors[] = ['Fan mavjud emas.'];
        } else {
            $questions = Questions::find()
                ->where(['subject_id' => $model->subject_id , 'status' => 1, 'is_deleted' => 0])
                ->count();
            if ($questions < $model->question_count) {
                //$errors[] = ['Ushbu fandan tasdiqlangan savollar yetarli emas!'];
            }
        }

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
