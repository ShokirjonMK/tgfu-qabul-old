<?php

namespace backend\controllers;

use common\models\CrmPush;
use common\models\Direction;
use common\models\DirectionSubject;
use common\models\EduYearForm;
use common\models\EduYearType;
use common\models\Exam;
use common\models\Languages;
use common\models\Message;
use common\models\StudentPerevot;
use common\models\StudentPerevotSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Student;
use kartik\mpdf\Pdf;

/**
 * StudentPerevotController implements the CRUD actions for StudentPerevot model.
 */
class ContractController extends Controller
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

    public function actionIndex($id , $type)
    {
        $student = Student::findOne(['id' => $id]);
        $user = $student->user;

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
//                $amoCrmClient = \Yii::$app->ikAmoCrm;
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
//                \Yii::$app->session->setFlash('error' , $errors);
//                return $this->redirect(['cabinet/index']);
//            }
//        }
        return $pdf->render();
    }

    public function actionBug8()
    {

        return $this->redirect(['site/index']);
    }
}
