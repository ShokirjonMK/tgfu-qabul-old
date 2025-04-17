<?php

namespace frontend\models;

use common\models\AuthAssignment;
use common\models\CrmPush;
use common\models\Message;
use common\models\Student;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $reset_password;
    public $password;


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
                'message' => 'Bu telefon raqam avval ro\'yhatdan o\'tgan.',
                'when' => function ($model) {
                    $user = User::findOne(['username' => $model->username]);
                    return $user && $user->status == 10;
                }
            ],
            [
                'username',
                'match',
                'pattern' => '/^[+][0-9]{3} [(][0-9]{2}[)] [0-9]{3}-[0-9]{2}-[0-9]{2}$/',
                'message' => 'Telefon raqamni to\'liq kiriting',
            ],

            [['password'], 'required'],
            [['reset_password'], 'required'],
            [['password' , 'reset_password'], 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            ['reset_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Parollar bir xil bo\'lishi kerak.'],
        ];
    }

    function simple_errors($errors) {
        $result = [];
        foreach ($errors as $lev1) {
            foreach ($lev1 as $key => $error) {
                $result[] = $error;
            }
        }
        return array_unique($result);
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if (!$this->validate()) {
            $errors[] = $this->simple_errors($this->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        $user = User::findUserStudent($this->username);
        if ($user) {
            if ($user->status == 10) {
                $errors[] = ['Telefon nomer avval ro\'yhatdan o\'tgan.'];
            } elseif ($user->status == 0) {
                $errors[] = ['Telefon raqam bloklangan.'];
            } elseif ($user->status == 9) {

                $user->setPassword($this->password);
                $user->generateAuthKey();
                $user->generateEmailVerificationToken();
                $user->generatePasswordResetToken();

                if ($user->sms_time <= time() || $user->sms_time == null) {
                    $user->sms_time = strtotime('+3 minutes', time());
                    $user->sms_number = rand(100000, 999999);
                }
                $user->get_token = User::ikToken();
                $user->save(false);

                $student = $user->student;
                $student->username = $this->username;
                $student->password = $this->password;
                $student->save(false);
            } else {
                $errors[] = ['Xatolik yuzaga keldi +998 94 505-5250 raqamiga aloqaga chiqing.'];
            }
        } else {
            $user = new User();
            $user->username = $this->username;
            $user->user_role = 'student';

            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->generatePasswordResetToken();

            $user->get_token = User::ikToken();
            $user->sms_time = strtotime('+3 minutes', time());
            $user->sms_number = rand(100000, 999999);
            $user->status = 9;

            $domen  = $_SERVER['HTTP_HOST'];

            if ($domen == "edu.tgfu.uz") {
                $user->cons_id = 2;
            }

            if ($user->save(false)) {
                $newAuth = new AuthAssignment();
                $newAuth->item_name = 'student';
                $newAuth->user_id = $user->id;
                $newAuth->created_at = time();
                $newAuth->save(false);

                $newStudent = new Student();
                $newStudent->user_id = $user->id;
                $newStudent->username = $user->username;
                $newStudent->password = $this->password;
                $newStudent->created_by = 0;
                $newStudent->updated_by = 0;
                $newStudent->save(false);

                // crm ga uzatish

                $crm = new CrmPush();
                $crm->student_id = $newStudent->id;
                $crm->type = 1;
                $crm->lead_status = User::STEP_STATUS_1;
                $crm->data_save_time = time();
                $crm->save(false);

//                $result = $this->sendCrm($user , $domen);
//                if ($result['is_ok']) {
//                    $amo = $result['data'];
//                    $newStudent->lead_id = $amo->id;
//                    $newStudent->pipeline_id = $amo->pipelineId;
//                    $newStudent->status_id = $amo->statusId;
//                    $newStudent->save(false);
//                } else {
//                    $errors[] = $result['errors'];
//                }
            } else {
                $errors[] = ['Student not saved.'];
            }
        }

        if (count($errors) == 0) {
            Message::sendSms($user->username, $user->sms_number);
            $transaction->commit();
            return ['is_ok' => true , 'user' => $user];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendCrm($user , $domen)
    {
        $errors = [];
        try {
            $amoCrmClient = Yii::$app->ikAmoCrm;

            $normalizedPhoneNumber = preg_replace('/[^\d+]/', '', $user->username);

            $leadName = $normalizedPhoneNumber;
            $message = '';
            $tags = ['@ikbol_2001'];
            $pipelineId = User::PIPELINE_ID;
            $statusId = User::STEP_STATUS_1;
            $leadPrice = 0;
            $customFields = [
                '1959579' => $leadName // Tel raqami
            ];

            $phoneNumber = $normalizedPhoneNumber;

            $newLead = $amoCrmClient->addLeadToPipeline(
                $phoneNumber,
                $leadName,
                $message,
                $tags,
                $customFields,
                $pipelineId,
                $statusId,
                $leadPrice
            );

            return ['is_ok' => true , 'data' => $newLead];
        } catch (\Exception $e) {
            return ['is_ok' => false, 'errors' => ['Ma\'lumot uzatishda xatolik: ' . $e->getMessage()]];
        }
    }
}
