<?php

namespace console\controllers;

use common\models\AuthAssignment;
use common\models\CrmPush;
use common\models\Direction;
use common\models\DirectionSubject;
use common\models\Exam;
use common\models\ExamSubject;
use common\models\Options;
use common\models\Questions;
use common\models\Student;
use common\models\StudentOferta;
use common\models\User;
use Yii;
use yii\console\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\httpclient\Client;

class CrmPushController extends Controller
{
    public function actionPush()
    {
        $transaction = Yii::$app->db->beginTransaction();

        $query = CrmPush::find()
            ->where(['status' => 0])
            ->andWhere(['<>' , 'is_deleted' , 20])
            ->andWhere(['or',
                ['and', ['type' => 1], ['lead_id' => null]],  // type 1 uchun lead_id null bo'lishi kerak
                ['and', ['<>', 'type', 1], ['is not', 'lead_id', null]]  // boshqalar uchun lead_id null emas
            ])
            ->orderBy('data_save_time asc')
            ->limit(5)
            ->all();

        if (!empty($query)) {
            foreach ($query as $item) {
                $result = null;
                switch ($item->type) {
                    case 1:
                        $result = self::type1($item);
                        break;
                    case 2:
                        $result = self::type2($item);
                        break;
                    case 3:
                        $result = self::type3($item);
                        break;
                    case 4:
                        $result = self::type4($item);
                        break;
                    case 5:
                        $result = self::type5($item);
                        break;
                    case 6:
                        $result = self::type6($item);
                        break;
                    case 7:
                        $result = self::type7($item);
                        break;
                    case 8:
                        $result = self::type8($item);
                        break;
                    case 9:
                        $result = self::type9($item);
                        break;
                    case 10:
                        $result = self::type10($item);
                        break;
                }

                if ($result !== null && $result['is_ok']) {
                    $amo = $result['data'];
                    $item->lead_id = $amo->id;
                    $item->status = 1;
                    if ($item->type == 1) {
                        $student = Student::findOne($item->student_id);
                        if ($student) {
                            CrmPush::updateAll(['lead_id' => $amo->id], ['student_id' => $student->id]);
                        }
                    }
                } else {
                    $item->is_deleted = 20;
                }
                $item->push_time = time();
                $item->save(false);
            }
        }

        $transaction->commit();
    }


    public static function type1($model)
    {
        $student = Student::findOne($model->student_id);
        if ($student) {
            try {
                $amoCrmClient = Yii::$app->ikAmoCrm;
                $normalizedPhoneNumber = preg_replace('/[^\d+]/', '', $student->username);

                $leadName = $normalizedPhoneNumber;
                $message = '';
                $tags = ['TGFU'];
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
                return ['is_ok' => false];
            }
        }
        return ['is_ok' => false];
    }

    public static function type2($model)
    {
        try {
            $amoCrmClient = Yii::$app->ikAmoCrm;
            $leadId = $model->lead_id;
            $tags = [];
            $customFields = [];
            $message = '';

            $updatedFields = [
                'statusId' => User::STEP_STATUS_2
            ];
            $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
            return ['is_ok' => true, 'data' => $updatedLead];
        } catch (\Exception $e) {
            return ['is_ok' => false];
        }
        return ['is_ok' => false];
    }

    public static function type3($model)
    {
        $student = Student::findOne($model->student_id);
        if ($student) {
            try {
                $amoCrmClient = Yii::$app->ikAmoCrm;
                $leadId = $model->lead_id;
                $tags = [];
                $message = '';

                $updatedFields = [
                    'statusId' => User::STEP_STATUS_3
                ];

                $customFields = [
                    '1959581' => $student->last_name, // Familya
                    '1959583' => $student->first_name, // Ism
                    '1959585' => $student->middle_name,  // Otasi
                    '1959587' => $student->passport_serial,  // pas seriya
                    '1959589' => $student->passport_number, // pas raqam
                    '1959591' => $student->birthday, // Tug'ilgan sana
                    '1959593' => null, // qabul turi
                    '1959595' => null, // Filial
                    '1959597' => null, // Ta'lim shakli
                    '1959599' => null, // Ta'lim tili
                    '1959601' => null, // Ta'lim yo'nalishi
                    '1959603' => null, // Imtixon shakli
                ];
                $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
                return ['is_ok' => true, 'data' => $updatedLead];
            } catch (\Exception $e) {
                return ['is_ok' => false];
            }
        }
        return ['is_ok' => false];
    }

    public static function type4($model)
    {
        $student = Student::findOne($model->student_id);
        if ($student) {
            try {
                $amoCrmClient = Yii::$app->ikAmoCrm;
                $leadId = $model->lead_id;
                $tags = [];
                $message = '';

                $updatedFields = [
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
                return ['is_ok' => false];
            }
        }
        return ['is_ok' => false];
    }

    public static function type5($model)
    {
        $student = Student::findOne($model->student_id);
        if ($student) {
            try {
                $amoCrmClient = Yii::$app->ikAmoCrm;
                $leadId = $model->lead_id;
                $tags = [];
                $message = '';

                $updatedFields = [
                    'statusId' => User::STEP_STATUS_5
                ];

                if ($student->edu_type_id == 1) {
                    $examTYpe = "Online";
                    if ($student->exam_type == 1) {
                        $examTYpe = "Offline";
                    }
                } else {
                    $examTYpe = "------";
                }

                $customFields = [
                    // '1959581' => $student->last_name, // Familya
                    // '1959583' => $student->first_name, // Ism
                    // '1959585' => $student->middle_name,  // Otasi
                    // '1959587' => $student->passport_serial,  // pas seriya
                    // '1959589' => $student->passport_number, // pas raqam
                    // '1959591' => $student->birthday, // Tug'ilgan sana
                    // '1959593' => $student->eduType->name_uz, // qabul turi
                    '1959595' => $student->filial->name_uz, // Filial
                    '1959597' => $student->eduForm->name_uz, // Ta'lim shakli
                    '1959599' => $student->language->name_uz, // Ta'lim tili
                    '1959601' => $student->direction->name_uz, // Ta'lim yo'nalishi
                    '1959603' => $examTYpe, // Imtixon shakli
                ];

                $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
                return ['is_ok' => true, 'data' => $updatedLead];
            } catch (\Exception $e) {
                return ['is_ok' => false];
            }
        }
        return ['is_ok' => false];
    }

    public static function type6($model)
    {
        try {
            $amoCrmClient = Yii::$app->ikAmoCrm;
            $leadId = $model->lead_id;
            $tags = [];
            $message = '';
            $customFields = [];

            $updatedFields = [
                'statusId' => User::STEP_STATUS_6
            ];

            $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
            return ['is_ok' => true, 'data' => $updatedLead];
        } catch (\Exception $e) {
            return ['is_ok' => false];
        }
        return ['is_ok' => false];
    }

    public static function type7($model)
    {
        try {
            $amoCrmClient = Yii::$app->ikAmoCrm;
            $leadId = $model->lead_id;
            $tags = [];
            $message = '';

            $updatedFields = [
                'statusId' => User::STEP_STATUS_7
            ];

            $customFields = [
                '1958937' => $model->data_save_time,
            ];

            $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
            return ['is_ok' => true, 'data' => $updatedLead];
        } catch (\Exception $e) {
            return ['is_ok' => false];
        }
        return ['is_ok' => false];
    }

    public static function type8($model)
    {
        try {
            $amoCrmClient = Yii::$app->ikAmoCrm;
            $leadId = $model->lead_id;
            $tags = [];
            $message = '';
            $customFields = [];

            $updatedFields = [
                'statusId' => User::STEP_STATUS_8
            ];

            $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
            return ['is_ok' => true, 'data' => $updatedLead];
        } catch (\Exception $e) {
            return ['is_ok' => false];
        }
        return ['is_ok' => false];
    }

    public static function type9($model)
    {
        $student = Student::findOne($model->student_id);
        if ($student) {
            try {
                $amoCrmClient = Yii::$app->ikAmoCrm;
                $leadId = $model->lead_id;
                $tags = [];
                $message = '';

                $customFields = [
                    '1959581' => $student->last_name, // Familya
                    '1959583' => $student->first_name, // Ism
                    '1959585' => $student->middle_name,  // Otasi
                    '1959587' => $student->passport_serial,  // pas seriya
                    '1959589' => $student->passport_number, // pas raqam
                    '1959591' => $student->birthday, // Tug'ilgan sana
                ];

                $updatedFields = [
                    'statusId' => User::STEP_STATUS_6
                ];

                $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
                return ['is_ok' => true, 'data' => $updatedLead];
            } catch (\Exception $e) {
                return ['is_ok' => false];
            }
        }
        return ['is_ok' => false];
    }

    public static function type10($model)
    {
        $student = Student::findOne($model->student_id);
        if ($student) {
            try {
                $amoCrmClient = Yii::$app->ikAmoCrm;
                $leadId = $model->lead_id;
                $tags = [];
                $message = '';

                $updatedFields = [
                    'statusId' => User::STEP_STATUS_6
                ];

                if ($student->edu_type_id == 1) {
                    $examTYpe = "Online";
                    if ($student->exam_type == 1) {
                        $examTYpe = "Offline";
                    }
                } else {
                    $examTYpe = "------";
                }

                $customFields = [
                    // '1959581' => $student->last_name, // Familya
                    // '1959583' => $student->first_name, // Ism
                    // '1959585' => $student->middle_name,  // Otasi
                    // '1959587' => $student->passport_serial,  // pas seriya
                    // '1959589' => $student->passport_number, // pas raqam
                    // '1959591' => $student->birthday, // Tug'ilgan sana
                    '1959593' => $student->eduType->name_uz, // qabul turi
                    '1959595' => $student->filial->name_uz, // Filial
                    '1959597' => $student->eduForm->name_uz, // Ta'lim shakli
                    '1959599' => $student->language->name_uz, // Ta'lim tili
                    '1959601' => $student->direction->name_uz, // Ta'lim yo'nalishi
                    '1959603' => $examTYpe, // Imtixon shakli
                ];

                $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
                return ['is_ok' => true, 'data' => $updatedLead];
            } catch (\Exception $e) {
                return ['is_ok' => false];
            }
        }
        return ['is_ok' => false];
    }

}
