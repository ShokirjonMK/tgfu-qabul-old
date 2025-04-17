<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "flayer".
 *
 * @property int $id
 * @property int|null $count
 * @property string|null $ip
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 */
class Flayer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'flayer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['count', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'count' => Yii::t('app', 'Count'),
            'ip' => Yii::t('app', 'Ip'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    public static function updateItem() {
        $transaction = Yii::$app->db->beginTransaction();

        $new = new Flayer();
        $new->count = 1;
        $new->created_at = time();
        $new->updated_at = time();
        $new->save(false);

        $transaction->commit();
    }
}
