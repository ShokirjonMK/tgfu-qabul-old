<?php

namespace backend\controllers;

use backend\models\AddBall;
use backend\models\Oferta;
use backend\models\Passport;
use backend\models\SendSms;
use backend\models\StepThree2;
use backend\models\StepThree3;
use backend\models\StepThree4;
use backend\models\UserUpdate;
use common\models\AuthAssignment;
use common\models\CrmPush;
use common\models\Direction;
use common\models\DirectionCourse;
use common\models\EduType;
use common\models\EduYearType;
use backend\models\StepThree;
use common\models\Exam;
use common\models\ExamStudentQuestions;
use common\models\ExamSubject;
use common\models\Student;
use common\models\StudentDtm;
use common\models\StudentDtmSearch;
use common\models\StudentMagistr;
use common\models\StudentOferta;
use common\models\StudentPerevot;
use common\models\StudentSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use common\models\EduYear;

/**
 * StudentDtmController implements the CRUD actions for StudentDtm model.
 */
class StudentController extends Controller
{
    use ActionTrait;
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all StudentDtm models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $edu_type = $this->eduTypeFindModel($id);
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $edu_type);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'edu_type' => $edu_type
        ]);
    }

    public function actionUserStep()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->step($this->request->queryParams);

        return $this->render('user-step', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSendSms($id)
    {
        $student = $this->studentSindModel($id);
        $model = new SendSms();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = $model->sendSms($student , $model);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view' , 'id' => $student->id]);
            }
        }

        return $this->renderAjax('_send-sms' , [
            'id' => $id,
            'model' => $model
        ]);
    }

    public function actionStepQabul($id)
    {
        $student = $this->studentSindModel($id);
        $user = $student->user;
        $model = new StepThree();

        $eduYear = EduYear::find()->where(['is_deleted' => 0 , 'status' => 1])->one();
        $eduYearType = EduYearType::findOne([
            'edu_type_id' => 1,
            'edu_year_id' => $eduYear->id,
        ]);
        $student->edu_year_type_id = $eduYearType->id;
        $student->edu_type_id = $eduYearType->edu_type_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = $model->ikStep($user , $student);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view' , 'id' => $student->id]);
            }
        }

        return $this->renderAjax('_form-step3' , [
            'id' => $id,
            'model' => $model,
            'student' => $student,
            'user' => $user,
            'eduYear' => $eduYear
        ]);
    }

    public function actionStepPerevot($id)
    {
        $student = $this->studentSindModel($id);
        $user = $student->user;
        $model = new StepThree2();

        $eduYear = EduYear::find()->where(['is_deleted' => 0 , 'status' => 1])->one();
        $eduYearType = EduYearType::findOne([
            'edu_type_id' => 2,
            'edu_year_id' => $eduYear->id,
        ]);
        $student->edu_year_type_id = $eduYearType->id;
        $student->edu_type_id = $eduYearType->edu_type_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = $model->ikStep($user , $student);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view' , 'id' => $student->id]);
            }
        }

        return $this->renderAjax('_form-step32' , [
            'id' => $id,
            'model' => $model,
            'student' => $student,
            'user' => $user,
            'eduYear' => $eduYear
        ]);
    }

    public function actionStepMagistr($id)
    {
        $student = $this->studentSindModel($id);
        $user = $student->user;
        $model = new StepThree4();

        $eduYear = EduYear::find()->where(['is_deleted' => 0 , 'status' => 1])->one();
        $eduYearType = EduYearType::findOne([
            'edu_type_id' => 4,
            'edu_year_id' => $eduYear->id,
        ]);
        $student->edu_year_type_id = $eduYearType->id;
        $student->edu_type_id = $eduYearType->edu_type_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = $model->ikStep($user , $student);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view' , 'id' => $student->id]);
            }
        }

        return $this->renderAjax('_form-step34' , [
            'id' => $id,
            'model' => $model,
            'student' => $student,
            'user' => $user,
            'eduYear' => $eduYear
        ]);
    }

    public function actionStepDtm($id)
    {
        $student = $this->studentSindModel($id);
        $user = $student->user;
        $model = new StepThree3();

        $eduYear = EduYear::find()->where(['is_deleted' => 0 , 'status' => 1])->one();
        $eduYearType = EduYearType::findOne([
            'edu_type_id' => 3,
            'edu_year_id' => $eduYear->id,
        ]);
        $student->edu_year_type_id = $eduYearType->id;
        $student->edu_type_id = $eduYearType->edu_type_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = $model->ikStep($user , $student);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view' , 'id' => $student->id]);
            }
        }

        return $this->renderAjax('_form-step33' , [
            'id' => $id,
            'model' => $model,
            'student' => $student,
            'user' => $user,
            'eduYear' => $eduYear
        ]);
    }

    public function actionDirection()
    {
        $form_id = yii::$app->request->post('form_id');
        $lang_id = yii::$app->request->post('lang_id');
        $type_id = yii::$app->request->post('type_id');

        $directions = Direction::find()
            ->where([
                'edu_year_type_id' => $type_id,
                'edu_year_form_id' => $form_id,
                'language_id' => $lang_id,
                'status' => 1,
                'is_deleted' => 0
            ])->all();

        $options = "";
        $options .= "<option value=''>Yo'nalish tanlang ...<option>";
        if (count($directions) > 0) {
            foreach ($directions as $direction) {
                $options .= "<option value='$direction->id'>". $direction->code ." - ". $direction->name_uz. " - ". $direction->eduType->name_uz ."</option>";
            }
        }
        return $options;
    }

    public function actionDirectionCourse()
    {
        $dir_id = yii::$app->request->post('dir_id');
        $type_id = yii::$app->request->post('type_id');

        $direction = Direction::findOne([
            'edu_year_type_id' => $type_id,
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

    public function actionExamSubjectBall($id)
    {
        $examSubject = $this->examSubjectfindModel($id);

        $model = new AddBall();
        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $result = AddBall::ball($model , $examSubject);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['student/view', 'id' => $examSubject->student_id]);
            }
        }

        return $this->renderAjax('confirm', [
            'model' => $model,
            'examSubject' => $examSubject
        ]);
    }

    public function actionTestDelete($id)
    {
        $exam = $this->examfindModel($id);

        $result = Exam::deleteBall($exam);
        if ($result['is_ok']) {
            \Yii::$app->session->setFlash('success');
        } else {
            \Yii::$app->session->setFlash('error' , $result['errors']);
        }

        return $this->redirect(['student/view', 'id' => $exam->student_id]);
    }

    protected function eduTypeFindModel($id)
    {
        if (($model = EduYearType::findOne(['id' => $id, 'is_deleted' => 0])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionInfo($id)
    {
        $student = $this->studentSindModel($id);

        $model = new Passport();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = $model->ikStep($student);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view' , 'id' => $student->id]);
            }
        }

        return $this->renderAjax('info' , [
            'model' => $model,
            'student' => $student,
        ]);
    }

    public function actionUserUpdate($id)
    {
        $student = $this->studentSindModel($id);

        $model = new UserUpdate();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = $model->ikStep($student);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view' , 'id' => $student->id]);
            }
        }

        return $this->renderAjax('user-update' , [
            'model' => $model,
            'student' => $student,
        ]);
    }

    protected function findModel($id)
    {
        $model = Student::findOne(['id' => $id]);
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    protected function studentSindModel($id)
    {
        $model = Student::findOne(['id' => $id]);
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    protected function examSubjectfindModel($id)
    {
        $model = ExamSubject::findOne(['id' => $id]);
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    protected function examfindModel($id)
    {
        $model = Exam::findOne(['id' => $id]);
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    protected function ofertafindModel($id)
    {
        $model = StudentOferta::findOne(['id' => $id]);
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionOfertaUpload($id)
    {
        $oferta = $this->ofertafindModel($id);
        $model = new Oferta();

        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $result = Oferta::upload($model , $oferta);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view', 'id' => $oferta->student_id]);
            }
        }

        return $this->renderAjax('oferta-upload', [
            'model' => $model,
        ]);
    }

    public function actionOfertaConfirm($id)
    {
        $model = $this->ofertafindModel($id);
        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $result = Oferta::check($model);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view', 'id' => $model->student_id]);
            }
        }

        return $this->renderAjax('oferta-confirm', [
            'model' => $model,
        ]);
    }

    public function actionDele($id)
    {
        $errors = [];
        $student = $this->studentSindModel($id);
        $user = Yii::$app->user->identity;
        $t = false;

        if ($user->user_role != "supper_admin") {
            if ($user->user_role == "admin") {
                if ($user->cons_id == $student->user->cons_id) {
                    $t = true;
                }
            }
        } else {
            $t = true;
        }
        if ($t) {

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
                $crm->type = 8;
                $crm->lead_id = $leadId;
                $crm->lead_status = User::STEP_STATUS_8;
                $crm->data_save_time = time();
                $crm->save(false);
            }

//            if ($student->lead_id != null) {
//                try {
//                    $amoCrmClient = Yii::$app->ikAmoCrm;
//                    $leadId = $student->lead_id;
//                    $tags = [];
//                    $message = '';
//                    $customFields = [];
//
//                    $updatedFields = [
//                        'pipelineId' => $student->pipeline_id,
//                        'statusId' => User::STEP_STATUS_8
//                    ];
//
//                    $updatedLead = $amoCrmClient->updateLead($leadId, $updatedFields, $tags, $message, $customFields);
//                } catch (\Exception $e) {
//                    $errors[] = ['Ma\'lumot uzatishda xatolik STEP 2: ' . $e->getMessage()];
//                    Yii::$app->session->setFlash('error' , $errors);
//                    return $this->redirect(['site/index']);
//                }
//            }

            StudentDtm::deleteAll(['student_id' => $student->id]);
            StudentPerevot::deleteAll(['student_id' => $student->id]);
            StudentOferta::deleteAll(['student_id' => $student->id]);
            StudentMagistr::deleteAll(['student_id' => $student->id]);
            ExamStudentQuestions::deleteAll(['user_id' => $student->user_id]);
            AuthAssignment::deleteAll(['user_id' => $student->user_id]);
            ExamSubject::deleteAll(['user_id' => $student->user_id]);
            Exam::deleteAll(['user_id' => $student->user_id]);
            Student::deleteAll(['id' => $student->id]);
            User::deleteAll(['id' => $student->user_id]);
            \Yii::$app->session->setFlash('success');
        } else {
            $errors[] = ["Ma'lumotni o'chirish imkonsiz!!!"];
            \Yii::$app->session->setFlash('error' , $errors);
        }
        return $this->redirect(['student/user-step']);
    }
}
