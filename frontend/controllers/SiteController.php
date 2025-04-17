<?php

namespace frontend\controllers;

use common\models\Flayer;
use common\models\Languages;
use common\models\Student;
use common\models\User;
use common\models\Verify;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPassword;
use frontend\models\StepOne;
use frontend\models\StepSecond;
use frontend\models\StepThree;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'bot' => ['post'],
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionCr()
    {
        $amoCrmClient = Yii::$app->ikAmoCrm;
        $lead = $amoCrmClient->getLoad(25266269);
        dd($lead);
    }


    public function actionIndex()
    {
        Yii::$app->session->remove('redirected_from_flayer');
        return $this->render('index');
    }

    public function actionFlayer()
    {
        $session = Yii::$app->session;
        if ($session->has('redirected_from_flayer')) {
            return $this->redirect(['site/index']);
        }
        Flayer::updateItem();
        $session->set('redirected_from_flayer', true);
        return $this->redirect(['site/index']);
    }

    public function actionUrl()
    {
        $referrer = isset($_SERVER) ? $_SERVER : '';

        dd($referrer);
        $referrer = htmlspecialchars($referrer, ENT_QUOTES, 'UTF-8');

        dd($referrer);

        $parsedUrl = parse_url($referrer);
        $domain = $parsedUrl['host'];

        dd($domain);
    }



    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['cabinet/index']);
        }

        $this->layout = '_cabinet-step';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['cabinet/index']);
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }


    public function actionSignUp()
    {
        $this->layout = '_cabinet-step';

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $result = $model->signup();
            if ($result['is_ok']) {
                return $this->redirect(['verify' , 'id' => $result['user']->get_token]);
            } else {
                Yii::$app->session->setFlash('error' , $result['errors']);
            }
        }

        return $this->render('sign-up', [
            'model' => $model
        ]);
    }

    public function actionResetPassword()
    {
        $this->layout = '_cabinet-step';

        $model = new ResetPassword();
        if ($model->load(Yii::$app->request->post())) {
            $result = $model->reset();
            if ($result['is_ok']) {
                return $this->redirect(['password-verify' , 'id' => $result['user']->get_token]);
            } else {
                Yii::$app->session->setFlash('error' , $result['errors']);
            }
        }

        return $this->render('reset-password', [
            'model' => $model
        ]);
    }

    public function actionPasswordVerify($id)
    {
        $this->layout = '_cabinet-step';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = $this->findUserActive($id);

        $model = new Verify();
        if ($model->load(Yii::$app->request->post())) {
            $result = Verify::password($user , $model);
            if ($result['is_ok']) {
                Yii::$app->session->setFlash('success');
                return $this->redirect(['cabinet/index']);
            }
            Yii::$app->session->setFlash('error' , $result['errors']);
            return $this->redirect(['password-verify' , 'id' => $result['user']->get_token]);
        }

        return $this->render('password-verify', [
            'model' => $model,
            'user' => $user
        ]);
    }


    public function actionVerify($id)
    {
        $this->layout = '_cabinet-step';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = $this->findUser($id);
        $model = new Verify();
        if ($model->load(Yii::$app->request->post())) {
            $result = Verify::confirm($user , $model);
            if ($result['is_ok']) {
                Yii::$app->session->setFlash('success');
                return $this->redirect(['cabinet/index']);
            }
            Yii::$app->session->setFlash('error' , $result['errors']);
            return $this->redirect(['verify' , 'id' => $result['user']->get_token]);
        }

        return $this->render('verify', [
            'model' => $model,
            'user' => $user
        ]);
    }



    public function actionPassSendSms($id)
    {
        $this->layout = '_cabinet-step';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = $this->findUserActive($id);

        $result = Verify::sendSms($user);

        if ($result['is_ok']) {
            Yii::$app->session->setFlash('success');
        } else {
            Yii::$app->session->setFlash('error' , $result['errors']);
        }
        return $this->redirect(['password-verify' , 'id' => $result['user']->get_token]);
    }


    public function actionSendSms($id)
    {
        $this->layout = '_cabinet-step';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = $this->findUser($id);

        $result = Verify::sendSms($user);
        if ($result['is_ok']) {
            Yii::$app->session->setFlash('success');
        } else {
            Yii::$app->session->setFlash('error' , $result['errors']);
        }
        return $this->redirect(['verify' , 'id' => $result['user']->get_token]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    protected function findUser($id)
    {
        $model = User::findOne(['get_token' => $id, 'user_role' => 'student' , 'status' => 9]);
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException();
    }

    protected function findUserActive($id)
    {
        $model = User::findOne(['get_token' => $id, 'user_role' => 'student' , 'status' => 10]);
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException();
    }


    public function actionLang($id)
    {
        $model = $this->findLang($id);
        $lang = 'uz';
        if ($model->id == 2) {
            $lang = 'en';
        } elseif ($model->id == 3) {
            $lang = 'ru';
        }
        Yii::$app->session->set("lang" , $lang);
        Yii::$app->language = $lang;
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function findLang($id)
    {
        $model = Languages::findOne(['id' => $id]);
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException();
    }
}
