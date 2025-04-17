<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $image
 * @property string|null $middle_name
 * @property string $phone
 * @property int $gender
 * @property string $brithday
 * @property string $adress
 * @property string $password
 * @property int|null $status
 *
 * @property User $user
 */
class Director extends \yii\db\ActiveRecord
{
    use ResourceTrait;

    public $username;

    public $avatar;

    public $avatarMaxSize = 1024 * 1000 * 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 5, 'max' => 20],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            [['first_name', 'last_name', 'phone', 'gender', 'brithday', 'adress', 'password'], 'required'],
            [['payment_type' , 'payment_cost','user_id', 'gender', 'status' ,'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['adress'], 'string'],
            [
                'phone',
                'match',
                'pattern'=>'/^[+][0-9]{3} [(][0-9]{2}[)] [0-9]{3}-[0-9]{2}-[0-9]{2}$/',
                'message'=> 'Telefon raqamni to\'liq kiriting',
            ],
            [
                [ 'avatar' ],
                'file',
                'extensions'=>'jpg, png',
                'skipOnEmpty'=>true,
                'maxSize' => $this->avatarMaxSize
            ],
            [['first_name', 'last_name', 'middle_name', 'phone', 'password' , 'image'], 'string', 'max' => 255],
            [['brithday'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            ['username' , 'validateUnique']
        ];
    }

    public function validateUnique($attribute, $params)
    {
        $query = User::find()
            ->where(['username' => $this->username])
            ->andWhere(['!=' , 'id' , $this->user_id])
            ->one();
        if ($query) {
            $this->addError($attribute, 'This username has already been taken.');
        }
    }


    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'first_name' => Yii::t('app', 'Fisrt Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'phone' => Yii::t('app', 'Phone'),
            'gender' => Yii::t('app', 'Gender'),
            'brithday' => Yii::t('app', 'Brithday'),
            'adress' => Yii::t('app', 'Adress'),
            'password' => Yii::t('app', 'Password'),
            'status' => Yii::t('app', 'Status'),
        ];
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

    public static function createUser($model , $role) {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $time = time();

        if (!$model->validate()) {
            $errors[] = $model->simple_errors($model->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        $imageFile = UploadedFile::getInstance($model, 'avatar');
        if ($imageFile) {
            if (isset($imageFile->size)) {
                if ($imageFile->saveAs('uploads/employee/' . $time . '.' . $imageFile->extension)) {
                    $model->image = $time . '.' . $imageFile->extension;
                }
            }
        }

        $user = new User();
        $user->username = $model->username;
        $user->user_role = $role;
        $user->education_id = Yii::$app->user->identity->education_id;
        $user->setPassword($model->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->email = 'employee'.Yii::$app->user->identity->education_id.time().'@gmail.com';

        if ($model->status == 1) {
            $user->status = User::STATUS_ACTIVE;
        } else {
            $user->status = User::STATUS_INACTIVE;
        }

        if ($user->save()) {
            $model->user_id = $user->id;
            $newAuth = new AuthAssignment();
            $newAuth->item_name = $role;
            $newAuth->user_id = $user->id;
            $newAuth->created_at = time();
            $newAuth->save(false);
        } else {
            $errors[] = ['User not saved.'];
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
        if (!$model->save(false)) {
            $errors[] = ['Employee not saved.'];
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }

    public static function updateUser($model , $role, $user) {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $time = time();

        if (!$model->validate()) {
            $errors[] = $model->simple_errors($model->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        $imageFile = UploadedFile::getInstance($model, 'avatar');
        if ($imageFile) {
            if (isset($imageFile->size)) {
                if ($imageFile->saveAs('uploads/employee/' . $time . '.' . $imageFile->extension)) {
                    $model->image = $time . '.' . $imageFile->extension;
                }
            }
        }

        $user->username = $model->username;
        $user->user_role = $role;
        $user->setPassword($model->password);
        if ($model->status == 1) {
            $user->status = User::STATUS_ACTIVE;
        } else {
            $user->status = User::STATUS_INACTIVE;
        }

        if (!$user->save()) {
            $errors[] = ['User not saved.'];
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
        if (!$model->save(false)) {
            $errors[] = ['Employee not saved.'];
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
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
