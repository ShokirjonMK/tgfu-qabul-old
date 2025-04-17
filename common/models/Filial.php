<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "filial".
 *
 * @property int $id
 * @property string $name_uz
 * @property string $name_ru
 * @property string $name_en
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 *
 * @property Student[] $students
 */
class Filial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'filial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz', 'name_ru',
                'name_en',
                'univer_name_uz',
                'address_uz',
                'address_link',
                'phone',
                'h_r',
                'bank_uz',
                'mfo',
                'stir',
                'oked',
                'prorektor_uz',
                ], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['name_uz', 'name_ru',
                'name_en',
                'univer_name_uz',
                'address_uz',
                'address_link',
                'phone',
                'h_r',
                'bank_uz',
                'mfo',
                'stir',
                'oked',
                'prorektor_uz',
            ], 'string', 'max' => 255],
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
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::class, ['filial_id' => 'id']);
    }
}
