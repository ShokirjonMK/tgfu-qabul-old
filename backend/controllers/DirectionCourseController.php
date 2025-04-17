<?php

namespace backend\controllers;

use common\models\Direction;
use common\models\DirectionCourse;
use common\models\DirectionCourseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DirectionCourseController implements the CRUD actions for DirectionCourse model.
 */
class DirectionCourseController extends Controller
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
     * Lists all DirectionCourse models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $direction = $this->findDirectionModel($id);
        $searchModel = new DirectionCourseSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $direction);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'direction' => $direction
        ]);
    }

    /**
     * Creates a new DirectionCourse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $direction = $this->findDirectionModel($id);
        $model = new DirectionCourse();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = DirectionCourse::createItem($model , $direction);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                    return $this->redirect(['index' , 'id' => $direction->id]);
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                    return $this->redirect(\Yii::$app->request->referrer);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'direction' => $direction
        ]);
    }

    /**
     * Updates an existing DirectionCourse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $direction = $model->direction;
        if ($this->request->isPost && $model->load($this->request->post())) {
            $result = DirectionCourse::createItem($model , $direction);
            if ($result['is_ok']) {
                \Yii::$app->session->setFlash('success');
                return $this->redirect(['index' , 'id' => $direction->id]);
            } else {
                \Yii::$app->session->setFlash('error' , $result['errors']);
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'direction' => $direction
        ]);
    }

    /**
     * Deletes an existing DirectionCourse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->is_deleted = 1;
        $model->save(false);
        \Yii::$app->session->setFlash('success');
        return $this->redirect(['index' , 'id' => $model->direction_id]);
    }

    /**
     * Finds the DirectionCourse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DirectionCourse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DirectionCourse::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findDirectionModel($id)
    {
        if (($model = Direction::findOne(['id' => $id , 'is_deleted' => 0 , 'edu_type_id' => 2])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
