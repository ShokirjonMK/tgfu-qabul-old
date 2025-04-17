<?php

namespace backend\controllers;

use common\models\Telegram;
use common\models\TelegramDtm;
use common\models\TelegramOferta;
use common\models\TelegramPerevot;
use common\models\TelegramSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TelegramController implements the CRUD actions for Telegram model.
 */
class TelegramController extends Controller
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
     * Lists all Telegram models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TelegramSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionConfirm($id)
    {
        $model = $this->findModel($id);
        $result = Telegram::confirm($model);
        if ($result['is_ok']) {
            Telegram::sendChatSms($model);
            \Yii::$app->session->setFlash('success');
        } else {
            \Yii::$app->session->setFlash('error' , $result['errors']);
        }
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Displays a single Telegram model.
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
     * Updates an existing Telegram model.
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

    /**
     * Deletes an existing Telegram model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteCanel($id)
    {
        $model = $this->findModel($id);
        TelegramOferta::deleteAll(['telegram_id' => $model->id]);
        TelegramPerevot::deleteAll(['telegram_id' => $model->id]);
        TelegramDtm::deleteAll(['telegram_id' => $model->id]);
        Telegram::sendCancel($model);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Telegram model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Telegram the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Telegram::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
