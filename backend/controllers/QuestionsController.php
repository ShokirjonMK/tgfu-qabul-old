<?php

namespace backend\controllers;

use common\models\Questions;
use common\models\QuestionsSearch;
use common\models\Subjects;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * QuestionsController implements the CRUD actions for Questions model.
 */
class QuestionsController extends Controller
{
    /**
     * @inheritDoc
     */
    use ActionTrait;
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
     * Lists all Questions models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $subject = $this->findSubjectModel($id);
        $searchModel = new QuestionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $subject);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'subject' => $subject
        ]);
    }

    /**
     * Displays a single Questions model.
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
     * Creates a new Questions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $subject = $this->findSubjectModel($id);

        $model = new Questions();
        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $model->subject_id = $subject->id;
                $result = Questions::createItem($model, $post);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                    $model->loadDefaultValues();
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'subject' => $subject
        ]);
    }

    /**
     * Updates an existing Questions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $oldModel = $model;
        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $model->subject_id = $oldModel->subject_id;
                $result = Questions::updateItem($model, $post , $oldModel);
                if ($result['is_ok']) {
                    Yii::$app->session->setFlash('success');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error' , $result['errors']);
                    $model->loadDefaultValues();
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Questions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->status == 1) {
            $errors[] = ['Tasdiqlangan savolni tahrirlab bo\'lmaydi.'];
            \Yii::$app->session->setFlash('error' , $errors);
        } else {
            $model->is_deleted = 1;
            $model->save(false);
            Yii::$app->session->setFlash('success');
        }

        return $this->redirect(['index' , 'id' => $model->subject_id]);
    }

    public function actionImgDelete($id)
    {
        $errors = [];
        $model = $this->findModel($id);
        if ($model->status != 0) {
            $errors[] = ['Bu savol tasdiqlangan'];
        } else {
            $fileName = \Yii::getAlias('@backend/web/uploads/questions/'.$model->image);
            $model->image = null;
        }

        if (count($errors) == 0) {
            \Yii::$app->session->setFlash('success');
            if (file_exists($fileName)) {
                unlink($fileName);
            }
            $model->save(false);
        } else {
            \Yii::$app->session->setFlash('error' , $errors);
        }
        return $this->redirect(['questions/view' , 'id' => $model->id]);
    }

    public function actionCheck($id)
    {
        $model = $this->findModel($id);

        $result = Questions::checkItem($model);
        if ($result['is_ok']) {
            Yii::$app->session->setFlash('success');
        } else {
            Yii::$app->session->setFlash('error' , $result['errors']);
        }
        return $this->redirect(['index', 'id' => $model->subject_id]);
    }

    /**
     * Finds the Questions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Questions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Questions::findOne(['id' => $id , 'is_deleted' => 0])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findSubjectModel($id)
    {
        if (($model = Subjects::findOne(['id' => $id , 'is_deleted' => 0])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
