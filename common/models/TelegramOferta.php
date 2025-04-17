<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "telegram_oferta".
 *
 * @property int $id
 * @property int $telegram_id
 * @property string|null $file
 * @property int|null $file_status
 *
 * @property Telegram $telegram
 */
class TelegramOferta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_oferta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telegram_id'], 'required'],
            [['telegram_id', 'file_status'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['telegram_id'], 'exist', 'skipOnError' => true, 'targetClass' => Telegram::class, 'targetAttribute' => ['telegram_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'telegram_id' => 'Telegram ID',
            'file' => 'File',
            'file_status' => 'File Status',
        ];
    }

    /**
     * Gets query for [[Telegram]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTelegram()
    {
        return $this->hasOne(Telegram::class, ['id' => 'telegram_id']);
    }
}
