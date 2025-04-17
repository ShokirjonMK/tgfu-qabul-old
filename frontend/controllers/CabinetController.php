<?php

namespace frontend\controllers;

use common\models\Direction;
use common\models\DirectionCourse;
use common\models\Exam;
use common\models\ExamStudentQuestions;
use common\models\ExamStudentQuestionsSearch;
use common\models\ExamSubject;
use common\models\Options;
use common\models\Questions;
use common\models\Student;
use common\models\StudentDtm;
use common\models\StudentOferta;
use common\models\StudentPerevot;
use common\models\Subjects;
use frontend\models\SerCreate;
use frontend\models\SerDel;
use frontend\models\StepFour;
use frontend\models\StepOne;
use frontend\models\StepSecond;
use frontend\models\StepThree;
use frontend\models\StepThree2;
use frontend\models\StepThree3;
use frontend\models\StepThree4;
use frontend\models\Test;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;


/**
 * Site controller
 */
class CabinetController extends Controller
{

    public $layout = 'cabinet';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['student'],
                    ],
                ],
            ],
        ];
    }


    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            $controllerCheck = Yii::$app->controller->id;
            $actionCheck = Yii::$app->controller->action->id;
            if (!($controllerCheck == 'cabinet' && $actionCheck == 'step')) {
                $user = Yii::$app->user->identity;
                if ($user->step < 5) {
                    Yii::$app->response->redirect(['cabinet/step', 'id' => $user->step]);
                    return false;
                }
            }
        } else {
            Yii::$app->response->redirect(['site/login']);
            return false;
        }
        return parent::beforeAction($action); // Ensure this returns true or false
    }


    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        return $this->render('index' , [
            'student' => $student
        ]);
    }

    public function actionConnection()
    {
        return $this->render('connection');
    }

    public function actionExamList()
    {
        return $this->render('exam-list');
    }

    public function actionSendFile()
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        return $this->render('send-file' , [
            'student' => $student
        ]);
    }

    public function actionDownloadFile()
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        return $this->render('download-file' , [
            'student' => $student
        ]);
    }


    public function actionExam()
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);


        return $this->render('exam' , [
            'student' => $student
        ]);
    }




    public function actionTest()
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $result = Test::isCheck($student , $user);
        if (!$result['is_ok']) {
            \Yii::$app->session->setFlash('error' , $result['errors']);
            return $this->redirect(['exam']);
        }

        $exam = $result['data'];

        $searchModel = new ExamStudentQuestionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams , $exam);

        return $this->render('test' , [
            'exam' => $exam,
            'dataProvider' => $dataProvider,
            'student' => $student
        ]);

    }

    public function actionFinish($id)
    {
        $examStudent = $this->findExamStudentModel($id);
        if ($examStudent->status == 2) {
            $time = time();

            $finish_time = $examStudent->finish_time;

            $five_minutes_before = $finish_time - 300;

            if ($time < $five_minutes_before) {
                $examQuestions = ExamStudentQuestions::findOne([
                    'option_id' => null,
                    'exam_id' => $examStudent->id,
                    'status' => 1,
                    'is_deleted' => 0
                ]);
                if ($examQuestions) {
                    $errors[] = [$examQuestions->order." - savol belgilanmagan. Testni yakunlash uchun barcha javobni belgilashingiz shart!"];
                    \Yii::$app->session->setFlash('error' , $errors);
                    return $this->redirect(['test']);
                }
            }

            $result = Test::finishExam($examStudent);
            if (!$result['is_ok']) {
                \Yii::$app->session->setFlash('error' , $result['errors']);
            }
        }
        return $this->redirect(['exam']);
    }


    public function actionStep($id = null)
    {
        $this->layout = '_cabinet-step';
        $errors = [];
        $t = false;

        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        if ($student->edu_type_id == 1) {
            $qabul = Exam::findOne([
                'direction_id' => $student->direction_id,
                'student_id' => $student->id,
                'status' => 3,
                'is_deleted' => 0,
            ]);
            if ($qabul) {
                $t = true;
            }
        } elseif ($student->edu_type_id == 2) {
            $perevot = StudentPerevot::findOne([
                'direction_id' => $student->direction_id,
                'student_id' => $student->id,
                'file_status' => 2,
                'is_deleted' => 0
            ]);
            if ($perevot) {
                $t = true;
            }
        } elseif ($student->edu_type_id == 3) {
            $dtm = StudentDtm::findOne([
                'direction_id' => $student->direction_id,
                'student_id' => $student->id,
                'file_status' => 2,
                'is_deleted' => 0
            ]);
            if ($dtm) {
                $t = true;
            }
        }

        if ($t) {
            $errors[] = ['Shartnomangiz borligi sababli ma\'lumotni tahrirlay olmaysiz'];
            Yii::$app->session->setFlash('error' , $errors);
            return $this->redirect(['cabinet/index']);
        }

        if ($id == null) {
            $id = $user->step;
            if ($id > 4) {
                return $this->redirect(['cabinet/index']);
            }
        } else {
            if ($id > $user->step) {
                $id = $user->step;
            }
        }
        if ($id == 1) {
            $model = new StepOne();
        } elseif ($id == 2) {
            $model = new StepSecond();
        } elseif ($id == 3) {
            if ($student->edu_type_id == 1) {
                $model = new StepThree();
            } elseif ($student->edu_type_id == 2) {
                $model = new StepThree2();
            } elseif ($student->edu_type_id == 3) {
                $model = new StepThree3();
            } elseif ($student->edu_type_id == 4) {
                $model = new StepThree4();
            } else {
                $errors[] = ['XATOLIK!!!'];
                Yii::$app->session->setFlash('error' , $errors);
                return $this->redirect(['step' , 'id' => 1]);
            }
        } elseif ($id == 4) {
            $model = new StepFour();
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = $model->ikStep($user , $student);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['step']);
            }
        }


        return $this->render('step' , [
            'id' => $id,
            'model' => $model,
            'student' => $student,
            'user' => $user
        ]);
    }

    protected function findExamStudentModel($id)
    {
        $user = \Yii::$app->user->identity;
        if (($model = Exam::findOne(['id' => $id , 'user_id' => $user->id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException();
    }
}
