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
class Employee extends \yii\db\ActiveRecord
{
    use ResourceTrait;

    public $username;

    public $avatar;

    public $role;

    public $cons_id;

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
            ['username', 'unique',
                'targetClass' => User::class,
                'message' => 'Bu username avval ro\'yhatdan o\'tgan.',
                'when' => function ($model) {
                    $user = User::find()
                        ->where(['username' => $model->username])
                        ->andWhere(['<>' , 'id' , $model->user_id])
                        ->one();
                    return $user && $user != null;
                }
            ],
            ['username', 'string', 'min' => 5, 'max' => 20],
            ['role', 'string'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            [['first_name', 'last_name', 'phone', 'gender', 'brithday', 'adress', 'password','cons_id' , 'role' , 'status'], 'required'],
            [['user_id', 'gender', 'status' ,'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
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
            [['role'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::class, 'targetAttribute' => ['role' => 'name']],
            [['cons_id'], 'exist', 'skipOnError' => true, 'targetClass' => Constalting::class, 'targetAttribute' => ['cons_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'first_name' => Yii::t('app', 'Ism'),
            'last_name' => Yii::t('app', 'Familya'),
            'middle_name' => Yii::t('app', 'Otasi'),
            'phone' => Yii::t('app', 'Telefon raqam'),
            'gender' => Yii::t('app', 'Jinsi'),
            'brithday' => Yii::t('app', 'Tug\'ilgan sana'),
            'adress' => Yii::t('app', 'Adress'),
            'password' => Yii::t('app', 'Parol'),
            'username' => Yii::t('app', 'Login'),
            'role' => Yii::t('app', 'Rol'),
            'cons_id' => Yii::t('app', 'Xamkor'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Tizimga qo\'shilgan vaqt'),
            'updated_at' => Yii::t('app', 'Mal. o\'zgargan vaqt'),
            'created_by' => Yii::t('app', 'Kim tomonidan qo\'shilgan'),
            'updated_by' => Yii::t('app', 'Kim tomonidan o\'zgartirilgan'),
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

    public static function createUser($model , $role, $curUser) {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $model->adress = '.';
        if (!$model->validate()) {
            $errors[] = $model->simple_errors($model->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        if ($role->name == 'admin') {
            $model->cons_id = $curUser->cons_id;
            if (!($model->role == 'admin' || $model->role == 'moderator')) {
                $errors[] = ['Rol tanlashda xatolik!!!'];
                $transaction->rollBack();
                return ['is_ok' => false , 'errors' => $errors];
            }
        } elseif ($role->name == 'moderator') {
            $model->cons_id = $curUser->cons_id;
            $model->role = 'moderator';
        }


        $user = new User();
        $user->username = $model->username;
        $user->user_role = $model->role;
        $user->cons_id = $model->cons_id;
        $user->setPassword($model->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = $model->status;

        if ($user->save(false)) {
            $model->user_id = $user->id;
            $newAuth = new AuthAssignment();
            $newAuth->item_name = $model->role;
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

    public static function updateUser($model , $user , $role, $curUser) {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if (!$model->validate()) {
            $errors[] = $model->simple_errors($model->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        if ($role->name == 'admin') {
            $model->cons_id = $curUser->cons_id;
            if (!($model->role == 'admin' || $model->role == 'moderator')) {
                $errors[] = ['Rol tanlashda xatolik!!!'];
                $transaction->rollBack();
                return ['is_ok' => false , 'errors' => $errors];
            }
        } elseif ($role->name == 'moderator') {
            $model->cons_id = $curUser->cons_id;
            $model->role = 'moderator';
        }

        $oldRole = $user->user_role;

        $user->username = $model->username;
        $user->user_role = $model->role;
        $user->setPassword($model->password);
        $user->status = $model->status;
        $user->cons_id = $model->cons_id;

        if (!$user->save(false)) {

            if ($oldRole != $model->role) {
                $query = AuthAssignment::findOne([
                    'item_name' => $oldRole,
                    'user_id' => $user->id
                ]);
                if ($query) {
                    $query->delete();
                }
                $newAuth = new AuthAssignment();
                $newAuth->item_name = $model->role;
                $newAuth->user_id = $user->id;
                $newAuth->created_at = time();
                $newAuth->save(false);
            }

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


    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_by = Yii::$app->user->identity->id;
        } else {
            $this->updated_by = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($insert);
    }

}
