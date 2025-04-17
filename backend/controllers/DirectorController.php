<?php

namespace backend\controllers;

use common\models\Director;
use common\models\Employee;
use common\models\EmployeeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class DirectorController extends Controller
{
    use ActionTrait;

    public function actionView($id)
    {
        $array = [
            'id' => $id,
            'is_deleted' => 0
        ];
        $model = $this->findModel($array);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        $role = 'director';
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams , $role);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $model = new Director();
        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $role = 'director';
                $result = Director::createUser($model , $role);
                if ($result['is_ok']) {
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
        ]);
    }

    public function actionUpdate($id)
    {
        $array = [
            'id' => $id,
            'is_deleted' => 0
        ];
        $model = $this->findModel($array);

        $user = $model->user;
        $role = $model->user->user_role;
        $model->username = $user->username;
        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $result = Director::updateUser($model , $role, $user);
                if ($result['is_ok']) {
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
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionDelete($id)
    {
        $array = [
            'id' => $id,
            'is_deleted' => 0
        ];
        $model = $this->findModel($array);
        $user = Yii::$app->user->identity;
        if ($model->user_id != $user->id) {
            $model->is_deleted = 1;
            $model->save(false);
        } else {
            Yii::$app->session->setFlash('error' , [["O'zingizni ma'lumotingizni o'chira olmaysiz!"]]);
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Director the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($array)
    {
        $model = Director::findOne($array);
        $user = Yii::$app->user->identity;
        if ($model != null) {
            if ($model->user->education_id == $user->education_id && $model->user->user_role == 'director') {
                return $model;
            }
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
