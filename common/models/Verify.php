<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class Verify extends Model
{
    public $sms_code;
    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['sms_code'], 'required'],
            ['sms_code', 'integer', 'min' => 100000, 'max' => 999999, 'message' => 'SMS kod 6 xonali bo\'lishi kerak'],
        ];
    }


    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 14 : 0);
        }

        return false;
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

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    public static function confirm($user , $model) {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $time = time();

        if (!$model->validate()) {
            $errors[] = $model->simple_errors($model->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        $smsTime = $user->sms_time;

        if ($smsTime < $time) {
            $user->get_token = User::ikToken();
            $user->sms_time = strtotime('+3 minutes', time());
            $user->sms_number = rand(100000, 999999);
            $user->save(false);
            Message::sendSms($user->username, $user->sms_number);
        } else {
            if ($user->sms_number == $model->sms_code) {
                $user->status = 10;
                $user->get_token = null;
                $user->sms_number = 0;
                $user->sms_time = 0;
                $user->save(false);

                $student = $user->student;

                $queryCrm = CrmPush::findOne([
                    'student_id' => $student->id,
                    'type' => 1,
                ]);
                if ($queryCrm) {
                    $leadId = null;
                    if ($queryCrm) {
                        $leadId = $queryCrm->lead_id;
                    }
                    $crm = new CrmPush();
                    $crm->student_id = $student->id;
                    $crm->type = 2;
                    $crm->lead_id = $leadId;
                    $crm->lead_status = User::STEP_STATUS_2;
                    $crm->data_save_time = time();
                    $crm->save(false);
                }

                Yii::$app->user->login($user,  3600 * 15);
            } else {
                $errors[] = ['SMS kod noto\'g\'ri.'];
            }
        }

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true , 'user' => $user];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors, 'user' => $user];
        }
    }

    public static function sendSms($user) {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $t = false;

        $smsTime = $user->sms_time;

        if ($smsTime < time()) {
            $user->get_token = User::ikToken();
            $user->sms_time = strtotime('+3 minutes', time());
            $user->sms_number = rand(100000, 999999);
            $user->save(false);
            $t = true;
        } else {
            $errors[] = ['SMS tasdiqlash vaqti yakunlanmagan!'];
        }

        if (count($errors) == 0) {
            if ($t) {
                Message::sendSms($user->username, $user->sms_number);
            }
            $transaction->commit();
            return ['is_ok' => true , 'user' => $user];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors , 'user' => $user];
        }
    }

    public static function password($user , $model) {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $time = time() + 5;

        if (!$model->validate()) {
            $errors[] = $model->simple_errors($model->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }

        $smsTime = $user->sms_time;

        if ($smsTime < $time) {
            $user->get_token = User::ikToken();
            $user->sms_time = strtotime('+3 minutes', time());
            $user->sms_number = rand(100000, 999999);
            $user->save(false);
            Message::sendSms($user->username, $user->sms_number);
        } else {
            if ($user->sms_number == $model->sms_code) {

                $pass = $user->new_parol;
                $user->setPassword($user->new_parol);
                $user->generateAuthKey();
                $user->generateEmailVerificationToken();
                $user->generatePasswordResetToken();
                $user->get_token = null;
                $user->sms_number = 0;
                $user->sms_time = 0;
                $user->new_parol = null;
                $user->save(false);

                $student = $user->student;
                $student->password = $pass;
                $student->save(false);

                Yii::$app->user->login($user,  3600 * 24 * 7);
            } else {
                $errors[] = ['SMS kod noto\'g\'ri.'];
            }
        }

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true , 'user' => $user];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors, 'user' => $user];
        }
    }

    public static function updateCrm($student)
    {
        try {
            $amoCrmClient = Yii::$app->ikAmoCrm;
            $leadId = $student->lead_id;
            $tags = [];
            $customFields = [];
            $message = '';

            $updatedFields = [
                'pipelineId' => $student->pipeline_id,
                'statusId' => User::STEP_STATUS_2
            ];

            $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
            return ['is_ok' => true, 'data' => $updatedLead];
        } catch (\Exception $e) {
            $errors[] = ['Ma\'lumot uzatishda xatolik STEP 2: ' . $e->getMessage()];
            return ['is_ok' => false, 'errors' => $errors];
        }
    }
}
