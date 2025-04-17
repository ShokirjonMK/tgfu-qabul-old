<?php

namespace backend\controllers;

use common\models\Direction;
use common\models\DirectionSearch;
use common\models\DirectionSubject;
use common\models\EduYear;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DirectionController implements the CRUD actions for Direction model.
 */
class DirectionController extends Controller
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
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['supper_admin'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index'],
                            'roles' => ['admin' , 'moderator'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Direction models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DirectionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Direction model.
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
     * Creates a new Direction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Direction();
        $eduYear = EduYear::findOne([
            'status' => 1,
            'is_deleted' => 0
        ]);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = Direction::createItem($model , $eduYear);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                    return $this->redirect(['index']);
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
            'eduYear' => $eduYear,
        ]);
    }

    /**
     * Updates an existing Direction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $eduYear = EduYear::findOne([
            'status' => 1,
            'is_deleted' => 0
        ]);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = Direction::createItem($model , $eduYear);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                    return $this->redirect(['index']);
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                    return $this->redirect(\Yii::$app->request->referrer);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'eduYear' => $eduYear,
        ]);
    }

    /**
     * Deletes an existing Direction model.
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
        DirectionSubject::updateAll(['status' => 1, 'is_deleted' => 1] , ['direction_id' => $model->id, 'status' => 1, 'is_deleted' => 0]);
        \Yii::$app->session->setFlash('success');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Direction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Direction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Direction::findOne(['id' => $id , 'is_deleted' => 0])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
