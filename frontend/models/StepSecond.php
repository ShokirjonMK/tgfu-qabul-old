<?php

namespace frontend\models;

use common\models\AuthAssignment;
use common\models\CrmPush;
use common\models\EduYear;
use common\models\EduYearType;
use common\models\Exam;
use common\models\ExamStudentQuestions;
use common\models\ExamSubject;
use common\models\Message;
use common\models\Student;
use common\models\StudentDtm;
use common\models\StudentMagistr;
use common\models\StudentOferta;
use common\models\StudentPerevot;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\httpclient\Client;

/**
 * Signup form
 */
class StepSecond extends Model
{
    public $check;

    public function rules()
    {
        return [
            [['check'], 'safe'],
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

    public function ikStep($user, $student)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if (!$this->validate()) {
            $errors[] = $this->simple_errors($this->errors);
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
        $activeYear = EduYear::findOne([
            'status' => 1,
            'is_deleted' => 0
        ]);
        $eduYearType = EduYearType::findOne([
            'edu_year_id' => $activeYear->id,
            'id' => $this->check,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if (!$eduYearType) {
            $errors[] = ['Qabul turi noto\'g\'ri tanlandi.'];
        } else {
            if ($student->edu_year_type_id != $eduYearType->id) {

                Exam::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                ExamSubject::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                ExamStudentQuestions::updateAll(['status' => 0 , 'is_deleted' => 2] , ['user_id' => $student->user_id]);
                StudentOferta::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                StudentPerevot::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                StudentDtm::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);
                StudentMagistr::updateAll(['status' => 0 , 'is_deleted' => 2] , ['direction_id' => $student->direction_id , 'student_id' => $student->id]);

                $student->edu_year_type_id = $eduYearType->id;
                $student->edu_type_id = $eduYearType->eduType->id;
                $student->direction_id = null;
                $student->language_id = null;
                $student->edu_year_form_id = null;
                $student->edu_form_id = null;
                $student->direction_course_id = null;
                $student->course_id = null;
                $student->exam_type = null;
                $student->edu_name = null;
                $student->edu_direction = null;
                $student->save(false);
            }
            $user->step = 3;
            $user->save(false);

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
                $crm->type = 4;
                $crm->lead_id = $leadId;
                $crm->lead_status = User::STEP_STATUS_4;
                $crm->data_save_time = time();
                $crm->save(false);
            }
        }

        if (count($errors) == 0) {
//            if ($student->lead_id != null) {
//                $result = StepSecond::updateCrm($student);
//                if ($result['is_ok']) {
//                    $amo = $result['data'];
//                    $student->pipeline_id = $amo->pipelineId;
//                    $student->status_id = $amo->statusId;
//                    $student->save(false);
//                } else {
//                    return ['is_ok' => false, 'errors' => $result['errors']];
//                }
//            }
            $transaction->commit();
            return ['is_ok' => true];
        }
        $transaction->rollBack();
        return ['is_ok' => false, 'errors' => $errors];
    }

    public static function updateCrm($student)
    {
        try {
            $amoCrmClient = Yii::$app->ikAmoCrm;
            $leadId = $student->lead_id;
            $tags = [];
            $message = '';

            $updatedFields = [
                'pipelineId' => $student->pipeline_id,
                'statusId' => User::STEP_STATUS_4
            ];

            $customFields = [
                // '1959581' => $student->last_name, // Familya
                // '1959583' => $student->first_name, // Ism
                // '1959585' => $student->middle_name,  // Otasi
                // '1959587' => $student->passport_serial,  // pas seriya
                // '1959589' => $student->passport_number, // pas raqam
                // '1959591' => $student->birthday, // Tug'ilgan sana
                '1959593' => $student->eduType->name_uz, // qabul turi
                '1959595' => null, // Filial
                '1959597' => null, // Ta'lim shakli
                '1959599' => null, // Ta'lim tili
                '1959601' => null, // Ta'lim yo'nalishi
                '1959603' => null, // Imtixon shakli
            ];

            $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
            return ['is_ok' => true, 'data' => $updatedLead];
        } catch (\Exception $e) {
            $errors[] = ['Ma\'lumot uzatishda xatolik STEP 2: ' . $e->getMessage()];
            return ['is_ok' => false, 'errors' => $errors];
        }
    }


}
