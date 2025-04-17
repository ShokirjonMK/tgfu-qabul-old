<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "edu_year_type".
 *
 * @property int $id
 * @property int $edu_year_id
 * @property int $edu_type_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 *
 * @property EduType $eduType
 * @property EduYear $eduYear
 */
class EduYearType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_year_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edu_year_id', 'edu_type_id'], 'required'],
            [['edu_year_id', 'edu_type_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['edu_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduType::class, 'targetAttribute' => ['edu_type_id' => 'id']],
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
            'edu_type_id' => Yii::t('app', 'Edu Type ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
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
    public static function getEduTypeName($eduYear)
    {
        $eduYearTypes = EduYearType::find()->with('eduType')->where(['edu_year_id' => $eduYear->id,'is_deleted' => 0 , 'status' => 1])->all();
        $data = [];
        if (count($eduYearTypes) > 0) {
            foreach ($eduYearTypes as $eduYearType) {
                $data[$eduYearType->id] = $eduYearType->eduType->name_uz;
            }
        }
        return $data;
    }

}
