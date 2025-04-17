<?php

namespace frontend\models;

use common\models\Exam;
use common\models\ExamStudentQuestions;
use common\models\ExamSubject;
use common\models\Questions;
use common\models\StudentOferta;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\db\Expression;

/**
 * @property Exam $exam
 */
class Test extends Model
{
    const STARTED = 2;
    const FINISHED = 3;

    const TIME = 90 * 60;

    function simple_errors($errors) {
        $result = [];
        foreach ($errors as $lev1) {
            foreach ($lev1 as $key => $error) {
                $result[] = $error;
            }
        }
        return array_unique($result);
    }

    public static function isCheck($student , $user)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $time = time();
        $direction = $student->direction;


        if ($student->edu_type_id != 1) {
            $errors[] = ['Siz sinovdan o\'ta olmaysiz.'];
        } else {
            $exam = Exam::findOne([
                'direction_id' => $student->direction_id,
                'student_id' => $student->id,
                'is_deleted' => 0
            ]);
            if ($exam->status > 2) {
                $errors[] = ['Siz sinovni yakunlagansiz.'];
            } else {
                if ($direction->oferta == 1) {
                    $oferta = StudentOferta::findOne([
                        'direction_id' => $student->direction_id,
                        'student_id' => $student->id,
                        'status' => 1,
                        'is_deleted' => 0
                    ]);
                    if ($oferta->file_status != 2) {
                        $errors[] = ['Oferta tasdiqlanmagan!!!'];
                    }
                }
                if ($exam->status == 1) {
                    $subjects = ExamSubject::find()
                        ->where([
                            'exam_id' => $exam->id,
                            'status' => 1,
                            'is_deleted' => 0,
                        ])->all();

                    if (count($subjects) == 0) {
                        $errors[] = ['Exam Subjects not found.'];
                    } else {
                        $i = 1;
                        foreach ($subjects as $subject) {
                            ExamStudentQuestions::updateAll(['status' => 0 , 'is_deleted' => 2] , ['user_id' => $user->id ,'exam_subject_id' => $subject->id, 'status' => 1, 'is_deleted' => 0]);
                            $questionCount = $subject->directionSubject->question_count;
                            $query = Questions::find()
                                ->where([
                                    'subject_id' => $subject->subject_id,
                                    'status' => 1,
                                    'is_deleted' => 0
                                ])
                                ->orderBy(new Expression('rand()'))
                                ->limit($questionCount)
                                ->all();

                            if (count($query) != $questionCount) {
                                $errors[] = [$subject->subject->name_uz . " fanidan savollar yetarli emas."];
                            } else {
                                foreach ($query as $value) {
                                    $new = new ExamStudentQuestions();
                                    $new->user_id = $user->id;
                                    $new->exam_id = $exam->id;
                                    $new->exam_subject_id = $subject->id;
                                    $new->subject_id = $subject->subject_id;
                                    $new->question_id = $value->id;
                                    $new->option = $value->jsonOption;
                                    $new->order = $i;
                                    $new->save(false);
                                    $i++;
                                }
                            }
                        }
                        $examTime = time();
                        $exam->start_time = $examTime;
                        $exam->finish_time = $examTime + self::TIME;
                        $exam->status = 2;
                        $exam->save(false);
                    }

                } elseif ($exam->status == 2) {
                    if ($exam->finish_time <= $time) {


                        $exam = self::finish($exam);


                    }
                } else {
                    $errors[] = ['XATOLIK!!!'];
                }
            }
        }


        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true , 'data' => $exam];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }


    public static function finish($model)
    {
        $model->status = self::FINISHED;
        $examSubjects = $model->examSubjects;
        $direction = $model->direction;

        $model->ball = 0;
        foreach ($examSubjects as $examSubject) {
            $directionSubject = $examSubject->directionSubject;
            $one_ball = $directionSubject->ball;
            if ($examSubject->file_status == 2) {
                $examSubject->ball = $directionSubject->question_count * $one_ball;
                ExamStudentQuestions::updateAll(['is_correct' => 1] , ['exam_subject_id' => $examSubject->id , 'status' => 1, 'is_deleted' => 0]);
            } else {
                $questions = ExamStudentQuestions::find()
                    ->where([
                        'exam_subject_id' => $examSubject->id,
                        'is_correct' => 1,
                        'status' => 1,
                        'is_deleted' => 0
                    ])->count();
                $examSubject->ball = ($questions * $one_ball);
            }
            $model->ball = $model->ball + $examSubject->ball;
            $examSubject->save(false);
        }

        if ($model->ball < 56 && $model->ball >= 0) {
            $model->ball = rand(57 , 60);
        }

        $model->contract_type = 1;
        $model->contract_price = $direction->contract;
        $model->confirm_date = time();

        $model->save(false);

        return $model;
    }


    public static function finishExam($model)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];
        $time = time();

        $finish_time = $model->finish_time;

        if ($time < $finish_time) {
            $model->finish_time = $time;
        }

        $model = self::finish($model);

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true , 'data' => $model];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }


    public static function changeOption($questionId , $optionId)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $user = Yii::$app->user->identity;

        $examQuestions = ExamStudentQuestions::findOne([
            'id' => $questionId,
            'user_id' => $user->id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        $exam = Exam::findOne($examQuestions->exam_id);

        if ($exam->status == 2) {
            if (!($exam->finish_time >= time())) {
                $transaction->rollBack();
                return ['is_ok' => false];
            }
        } else {
            $transaction->rollBack();
            return ['is_ok' => false];
        }

        if (!$examQuestions || !json_decode($examQuestions->option) || !$examQuestions->question->correct) {
            $transaction->rollBack();
            return ['is_ok' => false];
        }

        $jsonOptions = json_decode($examQuestions->option);
        $isOptionFound = false;
        foreach ($jsonOptions as $jsonOption) {
            if ($jsonOption->id == $optionId) {
                $isOptionFound = true;
                break;
            }
        }

        if (!$isOptionFound) {
            $transaction->rollBack();
            return ['is_ok' => false];
        }

        $examQuestions->option_id = $optionId;
        $examQuestions->is_correct = ($examQuestions->question->correct->id == $optionId) ? 1 : 0;
        $examQuestions->save(false);

        $transaction->commit();
        return ['is_ok' => true];
    }
}
