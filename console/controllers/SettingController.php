<?php

namespace console\controllers;

use common\models\AuthAssignment;
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

class SettingController extends Controller
{
    public function actionTest()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $inputFileName = __DIR__ . '/excels/333.xlsx';
        $spreadsheet = IOFactory::load($inputFileName);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $bt = 0;
        foreach ($data as $key => $row) {
            if ($key != 0) {
                $phone = $row[0];
                $seria = $row[1];
                $number = (int)$row[2];
                $directionId = $row[3];
                $imtixon_turi = $row[4];
                $invois = $row[5];
                $entered = $row[6];
                $con_type = $row[7];
                $exanStudentId = $row[8];
                $ball = $row[9];
                $cr_at = $row[10];
                $bir = $row[11];

                echo $number."\n";
                if ($phone == 0) {
                    break;
                }
                $user = User::findOne(['username' => $phone]);
                if (!$user) {
                    $password = 'ikbol_2001';
                    $user = new User();
                    $user->username = $phone;
                    $user->user_role = 'student';

                    $user->setPassword($password);
                    $user->generateAuthKey();
                    $user->generateEmailVerificationToken();
                    $user->generatePasswordResetToken();
                    $user->status = 10;
                    $user->cons_id = 1;
                    $user->step = 1;
                    $user->save(false);

                    $newAuth = new AuthAssignment();
                    $newAuth->item_name = 'student';
                    $newAuth->user_id = $user->id;
                    $newAuth->created_at = time();
                    $newAuth->save(false);

                    $newStudent = new Student();
                    $newStudent->user_id = $user->id;
                    $newStudent->username = $user->username;
                    $newStudent->password = $password;
                    $newStudent->created_by = 0;
                    $newStudent->updated_by = 0;
                    $newStudent->save(false);

                    if ($seria != null && $number != null && $bir != null) {
                        $client = new Client();
                        $url = 'https://api.online-mahalla.uz/api/v1/public/tax/passport';
                        $params = [
                            'series' => $seria,
                            'number' => $number,
                            'birth_date' => date('Y-m-d' , strtotime($bir)),
                        ];
                        $response = $client->createRequest()
                            ->setMethod('GET')
                            ->setUrl($url)
                            ->setData($params)
                            ->send();

                        if ($response->isOk) {
                            $responseData = $response->data;
                            $passport = $responseData['data']['info']['data'];
                            $newStudent->first_name = $passport['name'];
                            $newStudent->last_name = $passport['sur_name'];
                            $newStudent->middle_name = $passport['patronymic_name'];
                            $newStudent->passport_number = $number;
                            $newStudent->passport_serial = $seria;
                            $newStudent->passport_pin = (string)$passport['pinfl'];

                            $newStudent->passport_issued_date = date("Y-m-d" , strtotime($passport['expiration_date']));
                            $newStudent->passport_given_date = date("Y-m-d" , strtotime($passport['given_date']));
                            $newStudent->passport_given_by = $passport['given_place'];
                            $newStudent->birthday = date("Y-m-d" , strtotime($bir));
                            $newStudent->gender = $passport['gender'];

                            $newStudent->edu_year_type_id = 1;
                            $newStudent->edu_type_id = 1;
                            $newStudent->save(false);
                            $user->step = 3;
                            $user->save(false);

                            if ($directionId != null) {
                                $direaction = Direction::findOne(['id' => $directionId]);
                                if ($direaction) {
                                    $newStudent->direction_id = $direaction->id;
                                    $newStudent->edu_year_form_id = $direaction->edu_year_form_id;
                                    $newStudent->edu_form_id = $direaction->edu_form_id;
                                    $newStudent->language_id = $direaction->language_id;
                                    $newStudent->exam_type = $imtixon_turi;

                                    if ($direaction->oferta == 1) {
                                        $oferta = new StudentOferta();
                                        $oferta->user_id = $user->id;
                                        $oferta->student_id = $newStudent->id;
                                        $oferta->direction_id = $newStudent->direction_id;
                                        $oferta->save(false);
                                    }

                                    $exam = new Exam();

                                    if ($entered == 1 && $exanStudentId > 0) {
                                        if ($ball < 10) {
                                            $t = $ball;
                                            $exam->contract_type = 1.5;
                                            $exam->contract_price = $direaction->contract * 1.5;
                                        } elseif ($ball >= 10 && $ball <= 56) {
                                            $t = rand(58 , 65);
                                            $exam->contract_type = 1;
                                            $exam->contract_price = $direaction->contract;
                                        } else {
                                            $t = $ball;
                                            $exam->contract_type = 1;
                                            $exam->contract_price = $direaction->contract;
                                        }

                                        $exam->ball = $t;
                                        $exam->status = 3;
                                        $exam->confirm_date = $cr_at;

                                        $random = rand(0 , $ball);
                                        $ball2 = $ball - $random;
                                        $b = [$random , $ball2];
                                    }

                                    $exam->user_id = $user->id;
                                    $exam->student_id = $newStudent->id;
                                    $exam->direction_id = $newStudent->direction_id;
                                    $exam->language_id = $newStudent->language_id;
                                    $exam->edu_year_form_id = $newStudent->edu_year_form_id;
                                    $exam->edu_year_type_id = $newStudent->edu_year_type_id;
                                    $exam->edu_type_id = $newStudent->edu_type_id;
                                    $exam->edu_form_id = $newStudent->edu_form_id;
                                    $exam->correct_type = 1;
                                    $exam->created_by = 0;
                                    $exam->updated_by = 0;
                                    $exam->contract_second = '2'.$invois;
                                    $exam->contract_third = '3'.$invois;

                                    $directionSubjects = DirectionSubject::find()
                                        ->where([
                                            'direction_id' => $exam->direction_id,
                                            'status' => 1,
                                            'is_deleted' => 0
                                        ])->all();
                                    if (count($directionSubjects) > 0) {
                                        $exam->save(false);
                                        $i = 0;
                                        foreach ($directionSubjects as $directionSubject) {
                                            $examSubject = new ExamSubject();
                                            $examSubject->user_id = $user->id;
                                            $examSubject->student_id = $newStudent->id;
                                            $examSubject->exam_id = $exam->id;
                                            $examSubject->direction_id = $exam->direction_id;
                                            $examSubject->direction_subject_id = $directionSubject->id;
                                            $examSubject->subject_id = $directionSubject->subject_id;
                                            $examSubject->language_id = $exam->language_id;
                                            $examSubject->edu_year_form_id = $exam->edu_year_form_id;
                                            $examSubject->edu_year_type_id = $exam->edu_year_type_id;
                                            $examSubject->edu_type_id = $exam->edu_type_id;
                                            $examSubject->edu_form_id = $exam->edu_form_id;
                                            if ($entered == 1 && $exanStudentId > 0) {
                                                $examSubject->ball = $b[$i];
                                            }
                                            $examSubject->save(false);
                                            $i++;
                                        }

                                        $user->step = 5;
                                        $user->save(false);
                                    }
                                }
                            }

                        } else {
                            echo $phone."\n";
                        }
                    }
                }
                $bt++;
                echo $bt."\n";
            }
        }


        if (count($errors) == 0) {
            $transaction->commit();
            echo "tugadi.";
        } else {
            $transaction->rollBack();
            dd($errors);
        }
    }

}
