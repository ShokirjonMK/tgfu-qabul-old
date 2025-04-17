<?php

namespace common\models;

use common\models\AuthAssignment;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class DirectorForm extends Model
{
    public $username;
    public $password;

    public $image;
    public $avatarMaxSize = 1024 * 1000 * 5;

    public $last_name;
    public $first_name;
    public $middle_name;
    public $gender;
    public $avatar;
    public $brithday;
    public $phone;
    public $role;
    public $adress;
    public $password_open;
    public $education_id;
    public $status;

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 5, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            [['last_name' ,'first_name' , 'middle_name' , 'avatar' , 'role' , 'password_open'] , 'string' , 'max' => 255],
            [['adress'] , 'safe'],
            [['brithday'] , 'date' , 'format' => 'dd-mm-yyyy'],
            [['gender', 'education_id' ,'status'] , 'integer'],

            [['last_name' ,'first_name' , 'gender' , 'brithday' , 'education_id' ,'status' ,'phone' , 'adress' , 'gender'] , 'required'],
            [
                'phone',
                'match',
                'pattern'=>'/^[+][0-9]{3} [(][0-9]{2}[)] [0-9]{3}-[0-9]{2}-[0-9]{2}$/',
                'message'=> 'Telefon raqamni to\'liq kiriting',
            ],

            [
                [ 'image' ],
                'file',
                'extensions'=>'jpg, png',
                'skipOnEmpty'=>true,
                'maxSize' => $this->avatarMaxSize
            ],

        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */

    public static function signup($model , $imageFile)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $time = time();

        if (!$model->validate()) {
            $errors[] = $model->errors;
        }

        $user = new User();
        $user->username = $model->username;
        $user->setPassword($model->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->last_name = $model->last_name;
        $user->first_name = $model->first_name;
        $user->middle_name = $model->middle_name;
        $user->gender = $model->gender;
        $user->phone = $model->phone;
        $user->brithday = date($model->brithday);
        $user->role = 'director';
        $user->adress = $model->adress;
        $user->password_open = $model->password;
        $user->education_id = $model->education_id;

        if ($model->status == 1) {
            $user->status = User::STATUS_ACTIVE;
        } else {
            $user->status = User::STATUS_INACTIVE;
        }

        if ($imageFile) {
            if (isset($imageFile->size)) {
                if ($imageFile->saveAs('uploads/employee/' . Yii::$app->security->generateRandomString(10) . $time . '.' . $imageFile->extension)) {
                    $user->avatar = $time . '.' . $imageFile->extension;
                }
            }
        }

        if (!$user->validate()) {
            $errors[] = $user->errors;
        }

        dd($errors);
        if (count($errors) > 0) {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        if (!$user->save()) {
            $errors[] = ['Ma\'lumot saqlashda xatolik.'];
        } else {
            $newAssignment = new AuthAssignment();
            $newAssignment->item_name = 'director';
            $newAssignment->user_id = $user->id;
            $newAssignment->created_at = time();
            $newAssignment->save(false);
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
