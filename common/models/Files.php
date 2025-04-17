<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $name
 * @property string|null $file_id
 * @property string|null $url
 * @property string|null $file_unique_id
 * @property int|null $file_size
 * @property int|null $post_id
 * @property int|null $type 1 dokument 2 rasm 3 video 4 audio
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc} hozir buni serverda migrate qilolmaymiz sabab shokir akadad dostup bazaga ham yomi yoq perevotni ishlataylik uni ichida nimalr bor file bn file status boldi
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['url'], 'string'],
            [['file_size', 'post_id', 'type', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['file_id'], 'string', 'max' => 245],
            [['file_unique_id'], 'string', 'max' => 254],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'file_id' => 'File ID',
            'url' => 'Url',
            'file_unique_id' => 'File Unique ID',
            'file_size' => 'File Size',
            'post_id' => 'Post ID',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}