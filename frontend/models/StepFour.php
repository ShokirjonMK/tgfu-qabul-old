<?php

namespace frontend\models;

use common\models\AuthAssignment;
use common\models\CrmPush;
use common\models\Direction;
use common\models\DirectionCourse;
use common\models\DirectionForm;
use common\models\DirectionLanguage;
use common\models\EduYear;
use common\models\EduYearForm;
use common\models\EduYearType;
use common\models\Languages;
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
class StepFour extends Model
{
    public $check;

    public function rules()
    {
        return [
            [['check'], 'integer'],
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

        $direction = $student->direction;

        if ($direction->oferta == 1) {
            $oferta = StudentOferta::findOne([
                'direction_id' => $direction->id,
                'student_id' => $student->id,
                'status' => 1,
                'is_deleted' => 0
            ]);
            if ($oferta->file_status == 0) {
                $errors[] = ['5 yillik staj fayl yuklanmagan. Iltimos staj faylni yuklang!'];
            }
        }

        if ($student->edu_type_id == 2) {
            $perevot = StudentPerevot::findOne([
                'direction_id' => $direction->id,
                'student_id' => $student->id,
                'status' => 1,
                'is_deleted' => 0
            ]);
            if ($perevot->file_status == 0) {
                $errors[] = ['Transkript yuklanmagan. Iltimos transkriptni yuklang!'];
            }
        } elseif ($student->edu_type_id == 3) {
            $dtm = StudentDtm::findOne([
                'direction_id' => $direction->id,
                'student_id' => $student->id,
                'status' => 1,
                'is_deleted' => 0
            ]);
            if ($dtm->file_status == 0) {
                $errors[] = ['UZBMB  yuklanmagan. Iltimos UZBMBni yuklang!'];
            }
        } elseif ($student->edu_type_id == 4) {
            $magistr = StudentMagistr::findOne([
                'direction_id' => $direction->id,
                'student_id' => $student->id,
                'status' => 1,
                'is_deleted' => 0
            ]);
            if ($magistr->file_status == 0) {
                $errors[] = ['Diplom yuklanmagan. Iltimos diplomni yuklang!'];
            }
        }

        if (count($errors) == 0) {
            $user->step = 5;
            $user->created_at = time();
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
                $crm->type = 6;
                $crm->lead_id = $leadId;
                $crm->lead_status = User::STEP_STATUS_6;
                $crm->data_save_time = time();
                $crm->save(false);
            }

//            if ($student->lead_id != null) {
//                $result = StepFour::updateCrm($student);
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
                'statusId' => User::STEP_STATUS_6
            ];

            $customFields = [
                // '1959581' => $student->last_name, // Familya
                // '1959583' => $student->first_name, // Ism
                // '1959585' => $student->middle_name,  // Otasi
                // '1959587' => $student->passport_serial,  // pas seriya
                // '1959589' => $student->passport_number, // pas raqam
                // '1959591' => $student->birthday, // Tug'ilgan sana
                // '1959593' => null, // qabul turi
                // '1959595' => null, // Filial
                // '1959597' => null, // Ta'lim shakli
                // '1959599' => null, // Ta'lim tili
                // '1959601' => null, // Ta'lim yo'nalishi
                // '1959603' => null, // Imtixon shakli
            ];

            $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
            return ['is_ok' => true, 'data' => $updatedLead];
        } catch (\Exception $e) {
            $errors[] = ['Ma\'lumot uzatishda xatolik STEP 2: ' . $e->getMessage()];
            return ['is_ok' => false, 'errors' => $errors];
        }
    }

}
