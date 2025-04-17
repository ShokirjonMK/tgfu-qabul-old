<?php

namespace backend\controllers;

use backend\models\AddBall;
use common\models\Exam;
use common\models\ExamSearch;
use common\models\ExamSubject;
use common\models\Student;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use backend\models\SerCreate;
use backend\models\SerDel;

/**
 * ExamController implements the CRUD actions for Exam model.
 */
class ExamController extends Controller
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
     * Lists all Exam models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ExamSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Exam model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Exam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Exam();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Exam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionUpload($id)
    {
        $examSubject = ExamSubject::findOne([
            'id' => $id,
            'status' => 1,
            'is_deleted' => 0
        ]);
        if ($examSubject) {
            $student = $examSubject->student;
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
            return $this->renderAjax('upload', [
                'model' => $model,
                'examSubject' => $examSubject
            ]);
        }
    }

    public function actionConfirm($id)
    {
        $model = $this->subjectFindModel($id);

        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $result = ExamSubject::checkItem($model);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['student/view', 'id' => $model->student_id]);
            }
        }

        return $this->renderAjax('confirm', [
            'model' => $model,
        ]);
    }


    public function actionBall($id)
    {
        $examSubject = $this->subjectFindModel($id);

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
                return $this->redirect(['student/view', 'id' => $model->student_id]);
            }
        }

        return $this->renderAjax('confirm', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Exam model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Exam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Exam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Exam::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function subjectFindModel($id)
    {
        if (($model = ExamSubject::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
