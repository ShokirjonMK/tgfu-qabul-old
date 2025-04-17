<?php

namespace frontend\controllers;

use common\models\CrmPush;
use common\models\Direction;
use common\models\DirectionCourse;
use common\models\ExamSubject;
use common\models\Student;
use common\models\StudentDtm;
use common\models\StudentMagistr;
use common\models\StudentOferta;
use common\models\StudentPerevot;
use common\models\User;
use frontend\models\Contract;
use frontend\models\SerCreate;
use frontend\models\SerDel;
use frontend\models\StepFour;
use frontend\models\StepOne;
use frontend\models\StepSecond;
use frontend\models\StepThree;
use frontend\models\StepThree2;
use frontend\models\Test;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;


/**
 * Site controller
 */
class FileController extends Controller
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

    public function actionDirection()
    {
        $form_id = yii::$app->request->post('form_id');
        $lang_id = yii::$app->request->post('lang_id');
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $directions = Direction::find()
            ->where([
                'edu_year_type_id' => $student->edu_year_type_id,
                'edu_year_form_id' => $form_id,
                'language_id' => $lang_id,
                'status' => 1,
                'is_deleted' => 0
            ])->all();

        $options = "";
        $options .= "<option value=''>Yo'nalish tanlang ...<option>";
        if (count($directions) > 0) {
            foreach ($directions as $direction) {
                $options .= "<option value='$direction->id'>". $direction->code ." - ". $direction->name_uz. "</option>";
            }
        }
        return $options;
    }


    public function actionDirectionCourse()
    {
        $dir_id = yii::$app->request->post('dir_id');
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $direction = Direction::findOne([
            'edu_year_type_id' => $student->edu_year_type_id,
            'id' => $dir_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        $options = "";
        $options .= "<option value=''>Yakunlagan bosqichingiz ...<option>";

        if ($direction) {
            $directionCourses = DirectionCourse::find()
                ->where([
                    'direction_id' => $direction->id,
                    'status' => 1,
                    'is_deleted' => 0
                ])->orderBy('course_id asc')->all();
            if (count($directionCourses) > 0) {
                foreach ($directionCourses as $course) {
                    $options .= "<option value='$course->id'>{$course->course->name_uz}</option>";
                }
            }
        }

        return $options;
    }


    public function actionCreateSertificate($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $examSubject = ExamSubject::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($examSubject) {
            $model = new SerCreate();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerCreate::upload($model , $student , $examSubject);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('create-sertificate', [
                'model' => $model,
                'examSubject' => $examSubject
            ]);
        }
    }


    public function actionDelSertificate($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $query = ExamSubject::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($query) {
            $model = new SerDel();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerDel::upload($model , $student , $query);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('delete-sertificate', [
                'model' => $model,
                'query' => $query
            ]);
        }
    }


    public function actionDelOferta($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $query = StudentOferta::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($query) {
            $model = new SerDel();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerDel::upload($model , $student , $query);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('delete-sertificate', [
                'model' => $model,
                'query' => $query
            ]);
        }
    }

    public function actionDelTr($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $query = StudentPerevot::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($query) {
            $model = new SerDel();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerDel::upload($model , $student , $query);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('delete-sertificate', [
                'model' => $model,
                'query' => $query
            ]);
        }
    }

    public function actionCreateTr($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $examSubject = StudentPerevot::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($examSubject) {
            $model = new SerCreate();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerCreate::upload($model , $student , $examSubject);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('create-sertificate', [
                'model' => $model,
                'examSubject' => $examSubject
            ]);
        }
    }

    public function actionCreateOferta($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $examSubject = StudentOferta::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($examSubject) {
            $model = new SerCreate();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerCreate::upload($model , $student , $examSubject);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('create-sertificate', [
                'model' => $model,
                'examSubject' => $examSubject
            ]);
        }
    }

    public function actionOptionChange()
    {
        $questionId = \Yii::$app->request->post('question');
        $optionId = \Yii::$app->request->post('option');

        $result = Test::changeOption($questionId, $optionId);

        if ($result['is_ok']) {
            return 1;
        }
        return 0;
    }


    public function actionContract($type)
    {
        $errors = [];
        $errors[] = ['Qabul jarayoni yopildi. Shartnoma berish to\'xtatildi!'];
        Yii::$app->session->setFlash('error' , $errors);
        return $this->redirect(Yii::$app->request->referrer);

        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $action = '';
        if ($type == 2) {
            $action = 'con2-uz';
//            if ($student->language_id == 1) {
//                $action = 'con2-uz';
//            } elseif ($student->language_id == 3) {
//                $action = 'con2-ru';
//            }
        } elseif ($type == 3) {
            $action = 'con3-uz';
//            if ($student->language_id == 1) {
//                $action = 'con3-uz';
//            } elseif ($student->language_id == 3) {
//                $action = 'con3-ru';
//            }
        }

        $content = $this->renderPartial($action, [
            'student' => $student,
            'type' => $type,
            'user' => $user
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'marginLeft' => 25,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_DOWNLOAD,
            'content' => $content,
            'cssInline' => 'body { font-family: Times, "Times New Roman", serif; }',
            'filename' => date('YmdHis') . ".pdf",
            'options' => [
                'title' => 'Contract',
                'subject' => 'Student Contract',
                'keywords' => 'pdf, contract, student',
            ],
        ]);

        $queryCrm = CrmPush::findOne([
            'student_id' => $student->id,
            'type' => 1,
        ]);
        if ($queryCrm) {
            $leadId = null;
            if ($queryCrm) {
                $leadId = $queryCrm->lead_id;
            }
            $query = CrmPush::findOne([
                'student_id' => $student->id,
                'type' => 7,
                'is_deleted' => 0
            ]);
            if (!$query) {
                $crm = new CrmPush();
                $crm->student_id = $student->id;
                $crm->type = 7;
                $crm->lead_id = $leadId;
                $crm->lead_status = User::STEP_STATUS_7;
                $crm->data_save_time = time();
                $crm->save(false);
            }
        }

//        if ($student->lead_id != null) {
//            try {
//                $amoCrmClient = Yii::$app->ikAmoCrm;
//                $leadId = $student->lead_id;
//                $tags = [];
//                $message = '';
//                $customFields = [];
//
//                $updatedFields = [
//                    'pipelineId' => $student->pipeline_id,
//                    'statusId' => User::STEP_STATUS_7
//                ];
//
//                $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
//            } catch (\Exception $e) {
//                $errors[] = ['Ma\'lumot uzatishda xatolik STEP 2: ' . $e->getMessage()];
//                Yii::$app->session->setFlash('error' , $errors);
//                return $this->redirect(['cabinet/index']);
//            }
//        }

        return $pdf->render();
    }


    public function actionDelMg($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $query = StudentMagistr::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($query) {
            $model = new SerDel();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerDel::upload($model , $student , $query);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('delete-sertificate', [
                'model' => $model,
                'query' => $query
            ]);
        }
    }

    public function actionCreateMg($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $examSubject = StudentMagistr::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($examSubject) {
            $model = new SerCreate();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerCreate::upload($model , $student , $examSubject);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('create-sertificate', [
                'model' => $model,
                'examSubject' => $examSubject
            ]);
        }
    }


    public function actionDelDtm($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $query = StudentDtm::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($query) {
            $model = new SerDel();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerDel::upload($model , $student , $query);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('delete-sertificate', [
                'model' => $model,
                'query' => $query
            ]);
        }
    }

    public function actionCreateDtm($id)
    {
        $user = Yii::$app->user->identity;
        $student = Student::findOne(['user_id' => $user->id]);

        $examSubject = StudentDtm::findOne([
            'id' => $id,
            'student_id' => $student->id,
            'direction_id' => $student->direction_id,
            'status' => 1,
            'is_deleted' => 0
        ]);

        if ($examSubject) {
            $model = new SerCreate();
            if ($model->load(Yii::$app->request->post())) {
                $result = SerCreate::upload($model , $student , $examSubject);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->renderAjax('create-sertificate', [
                'model' => $model,
                'examSubject' => $examSubject
            ]);
        }
    }


}
