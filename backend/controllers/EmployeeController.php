<?php

namespace backend\controllers;

use common\models\Employee;
use common\models\EmployeeSearch;
use common\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use common\models\Constalting;
use common\models\AuthItem;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
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
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['supper_admin' , 'admin'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['view' , 'update'],
                            'roles' => ['moderator'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Employee models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $role = $user->authItem;
        $cons = Constalting::find();
        $roles = AuthItem::find();
        if ($role->name == 'admin') {
            $cons = $cons->andWhere(['id' => $user->cons_id]);
            $roles = $roles->andWhere(['name' => ['admin' , 'moderator']]);
        }
        $cons = $cons->all();
        $roles = $roles->all();

        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams , $cons , $roles , $user, $role);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cons' => $cons,
            'roles' => $roles,
            'user' => $user,
            'role' => $role,
        ]);
    }

    /**
     * Displays a single Employee model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $user = \Yii::$app->user->identity;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'user' => $user,
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionCreate()
    {
        $user = Yii::$app->user->identity;
        $role = $user->authItem;
        $cons = Constalting::find();
        $roles = AuthItem::find();
        if ($role->name == 'admin') {
            $cons = $cons->andWhere(['id' => $user->cons_id]);
            $roles = $roles->andWhere(['name' => ['admin' , 'moderator']]);
        } elseif ($role->name == 'moderator') {
            $cons = $cons->andWhere(['id' => $user->cons_id]);
            $roles = $roles->andWhere(['name' => ['moderator']]);
        }
        $cons = $cons->all();
        $roles = $roles->all();

        $model = new Employee();
        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $result = Employee::createUser($model , $role, $user);
                if ($result['is_ok']) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                    $model->loadDefaultValues();
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'cons' => $cons,
            'roles' => $roles,
        ]);
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $curUser = Yii::$app->user->identity;
        $role = $curUser->authItem;
        $cons = Constalting::find();
        $roles = AuthItem::find();
        if ($role->name == 'admin') {
            $cons = $cons->andWhere(['id' => $curUser->cons_id]);
            $roles = $roles->andWhere(['name' => ['admin' , 'moderator']]);
        } elseif ($role->name == 'moderator') {
            $cons = $cons->andWhere(['id' => $curUser->cons_id]);
            $roles = $roles->andWhere(['name' => ['moderator']]);
        }
        $cons = $cons->all();
        $roles = $roles->all();


        $user = $model->user;
        $model->role = $model->user->user_role;
        $model->username = $user->username;
        $model->cons_id = $user->cons_id;
        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $result = Employee::updateUser($model , $user , $role , $curUser);
                if ($result['is_ok']) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                    $model->loadDefaultValues();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'cons' => $cons,
            'roles' => $roles,
            'role' => $role
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
        $userId = \Yii::$app->user->identity->id;
        $model = $this->findModel($id);
        $user = $model->user;
        if ($user->id != $userId) {
            $user->status = 0;
            $model->status = 0;
            $user->save(false);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $user = \Yii::$app->user->identity;
        $role = $user->authItem;
        if ($role->name == 'supper_admin') {
            if (($model = Employee::findOne(['id' => $id])) !== null) {
                return $model;
            }
        } elseif ($role->name == 'admin') {
            $model = Employee::findOne(['id' => $id]);
            $modelUser = $model->user;
            if ($modelUser->cons_id == $user->cons_id) {
                if ($modelUser->user_role == 'admin' || $modelUser->user_role == 'moderator') {
                    return $model;
                }
            }
        } else {
            if (($model = Employee::findOne(['id' => $id , 'user_id' => $user->id])) !== null) {
                return $model;
            }
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
