<?php

namespace backend\controllers;

use backend\models\Oferta;
use common\models\StudentDtm;
use common\models\StudentMagistr;
use common\models\StudentPerevot;
use common\models\StudentPerevotSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentPerevotController implements the CRUD actions for StudentPerevot model.
 */
class StudentPerevotController extends Controller
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
     * Lists all StudentPerevot models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StudentPerevotSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentPerevot model.
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
     * Creates a new StudentPerevot model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new StudentPerevot();

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
     * Updates an existing StudentPerevot model.
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
        $oferta = $this->findModel($id);
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
                return $this->redirect(['student/view', 'id' => $oferta->student_id]);
            }
        }

        return $this->renderAjax('upload', [
            'model' => $model,
        ]);
    }

    public function actionUpload4($id)
    {
        $oferta = $this->findModel4($id);
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
                return $this->redirect(['student/view', 'id' => $oferta->student_id]);
            }
        }

        return $this->renderAjax('upload', [
            'model' => $model,
        ]);
    }

    public function actionUpload3($id)
    {
        $oferta = $this->findModel3($id);
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
                return $this->redirect(['student/view', 'id' => $oferta->student_id]);
            }
        }

        return $this->renderAjax('upload', [
            'model' => $model,
        ]);
    }



    public function actionCheck($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $result = StudentPerevot::checkItem($model);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['student/view', 'id' => $model->student_id]);
            }
        }

        return $this->renderAjax('check', [
            'model' => $model,
        ]);
    }

    public function actionCheck3($id)
    {
        $model = $this->findModel3($id);

        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $result = StudentPerevot::checkItem($model);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['student/view', 'id' => $model->student_id]);
            }
        }

        return $this->renderAjax('check', [
            'model' => $model,
        ]);
    }

    public function actionCheck4($id)
    {
        $model = $this->findModel4($id);

        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $result = StudentPerevot::checkItem($model);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['student/view', 'id' => $model->student_id]);
            }
        }

        return $this->renderAjax('check', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StudentPerevot model.
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
     * Finds the StudentPerevot model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return StudentPerevot the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentPerevot::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
    protected function findModel3($id)
    {
        if (($model = StudentDtm::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
    protected function findModel4($id)
    {
        if (($model = StudentMagistr::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
