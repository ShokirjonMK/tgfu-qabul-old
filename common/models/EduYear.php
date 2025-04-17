<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "edu_year".
 *
 * @property int $id
 * @property string $name
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 *
 * @property EduYearForm[] $eduYearForms
 * @property EduYearType[] $eduYearTypes
 */
class EduYear extends \yii\db\ActiveRecord
{
    use ResourceTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_year';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * Gets query for [[EduYearForms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEduYearForms()
    {
        return $this->hasMany(EduYearForm::class, ['edu_year_id' => 'id']);
    }

    /**
     * Gets query for [[EduYearTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEduYearTypes()
    {
        return $this->hasMany(EduYearType::class, ['edu_year_id' => 'id']);
    }
}
