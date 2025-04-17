<?php
namespace backend\controllers;

use backend\components\HttpBearerAuth;
use backend\components\PermissonCheck;
//use base\ResponseStatus;
use common\models\Actions;
use common\models\Permission;
use common\models\RoleRestriction;
use common\models\User;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

trait ActionTrait
{
    public function behaviors()
    {
        return [
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
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            if ($user->user_role == 'student') {
                Yii::$app->user->logout();
                return $this->redirect(['../admin/site/login'])->send();
            }
        } else {
            $controllerCheck = Yii::$app->controller->id;
            $actionCheck = Yii::$app->controller->action->id;
            if (!($controllerCheck == 'site' && $actionCheck == 'login')) {
                return $this->redirect(['../site/login'])->send();
            }
        }
        return parent::beforeAction($action);
    }

}
