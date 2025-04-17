<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "education".
 *
 * @property int $id
 * @property string $name
 * @property string $adress
 * @property string $phone
 * @property int|null $status
 * @property int|null $order
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $is_deleted
 *
 * @property EduUser[] $eduUsers
 */
class University extends \yii\db\ActiveRecord
{
    public $logo;
    public $avatarMaxSize = 1024 * 1000 * 5;
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
            ],
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => strtotime(date('Y-m-d H:i:s')),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'university';
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['name', 'adress', 'phone'], 'required'],
            [['adress'], 'string'],
            [['status', 'order', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted' ,'parent_id'], 'integer'],
            [['name' , 'bank_name','okonh','inn','bank_number'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [
                'phone',
                'match',
                'pattern'=>'/^[+][0-9]{3} [(][0-9]{2}[)] [0-9]{3}-[0-9]{2}-[0-9]{2}$/',
                'message'=> 'Telefon raqamni to\'liq kiriting',
            ],
            [
                [ 'logo' ],
                'file',
                'extensions'=>'jpg, png',
                'skipOnEmpty'=>true,
                'maxSize' => $this->avatarMaxSize
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'adress' => Yii::t('app', 'Adress'),
            'phone' => Yii::t('app', 'Phone'),
            'status' => Yii::t('app', 'Status'),
            'order' => Yii::t('app', 'Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    public static function createItem($model,$imageFile)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $time=time();

        if ($imageFile) {
            if (isset($imageFile->size)) {
                if ($imageFile->saveAs('uploads/university-logo/' . $time . '.' . $imageFile->extension)) {
                    $model->image = $time . '.' . $imageFile->extension;
                }
            }
        }

        if (!$model->validate()) {
            $errors[] = $model->error;
        }
        if (!$model->save()) {
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

    public static function updateItem($model , $imageFile , $modelImg)
    {
        $errors = [];
        $transaction = Yii::$app->db->beginTransaction();
        $time= time();

        if (isset($imageFile->size)){
            if ($modelImg != null) {
                unlink(Yii::$app->basePath . '/web/uploads/university-logo/' .$modelImg);
            }
            if ($imageFile->saveAs('uploads/university-logo/' . $time . '.' . $imageFile->extension)) {
                $model->image = $time . '.' . $imageFile->extension;
            }
        }


        if (!$model->validate()) {
            $errors[] = $model->error;
        }
        if (!$model->save()) {
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

    public static function switch($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        $user = Yii::$app->user->identity;
        $education = University::findOne(['id' => $id]);
        if (!$education) {
            $errors[] = ["Bunday o'quv markaz mavjud emas!"];
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
        if ($user->user_role == 'supper_admin') {
            $user->education_id = $education->id;
            $user->save(false);
        } else {
            $is_ok = false;
            $userEdu = University::findOne([
                'id' => $user->education_id,
                'status' => 1,
                'is_deleted' => 0
            ]);
            if ($education->parent_id == null) {
                if ($education->id == $userEdu->parent_id) {
                    $is_ok = true;
                }
            } else {
                if ($userEdu->parent_id == null) {
                    if ($education->parent_id == $userEdu->id) {
                        $is_ok = true;
                    }
                } else {
                    if ($education->parent_id == $userEdu->parent_id) {
                        $is_ok = true;
                    }
                }
            }

            if (!$is_ok) {
                $errors[] = ["Siz faqat o'zingizga tegishli bo'lgan markazga kirishingiz mumkin!"];
                $transaction->rollBack();
                return ['is_ok' => false , 'errors' => $errors];
            } else {
                $user->education_id = $education->id;
                $user->save(false);
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
            $this->created_by = Yii::$app->user->identity;
        } else {
            $this->updated_by = Yii::$app->user->identity;
        }
        return parent::beforeSave($insert);
    }

}
