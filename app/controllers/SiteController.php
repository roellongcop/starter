<?php

namespace app\controllers;

use Yii;
use app\filters\AccessControl;
use app\filters\IpFilter;
use app\filters\ThemeFilter;
use app\filters\UserFilter;
use app\filters\VerbFilter;
use app\helpers\App;
use app\models\VisitLog;
use app\models\form\ContactForm;
use app\models\form\LoginForm;
use app\models\form\PasswordResetForm;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'custom' => [
                'class' => UserFilter::className(),
                'class' => IpFilter::className(),
                'class' => ThemeFilter::className()
            ],
            'access' => [
                'class' => AccessControl::className(),
                'publicActions' => ['login', 'logout', 'reset-password']
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'verbActions' => [
                    'logout' => ['post'],
                ]
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
                'class' => 'yii\web\ErrorAction',
                'layout' => 'error'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionResetPassword()
    {
        $model = new PasswordResetForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->process();
        }

        return $this->redirect(['login']);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (App::isLogin()) {
            return $this->redirect(['dashboard/index']);
        }

        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $PSR = new PasswordResetForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            VisitLog::login();

            return $this->goBack();
        }

        $this->layout = 'login';
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
            'PSR' => $PSR,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        VisitLog::logout();
        Yii::$app->user->logout();



        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
