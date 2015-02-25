<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Users;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
        'access' => [
        'class' => AccessControl::className(),
        'only' => ['logout'],
        'rules' => [
        [
        'actions' => ['logout'],
        'allow' => true,
        'roles' => ['@'],
        ],
        ],
        ],
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        'logout' => ['post'],
        ],
        ],
        ];
    }

    public function actions()
    {
        return [
        'error' => [
        'class' => 'yii\web\ErrorAction',
        ],
        'captcha' => [
        'class' => 'yii\captcha\CaptchaAction',
        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
        ],
        ];
    }

    public function actionIndex(){
        $this->layout = 'master';
        $model = new LoginForm();
        return $this->render('index', ['model'=>$model]);
    }

    public function actionLogin()
    {
        $this->layout = 'noSideMenu';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['user/profile']);
        } else {
            return $this->render('login', [
                'model' => $model,
                ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister(){

        $this->layout='noSideMenu';
        $model = new Users;
        if(!empty(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())){
            if($model->password == $_POST['re_password']){
                $model->created_at = date('H:i:s Y-m-d', time());
                if($model->save()){
                    return $this->redirect(Url::to(['site/index']));
                }
            }else{
            $model->addError('password', 'The passwords do not match');
        }     
        }
    return $this->render('register1', ['model'=>$model]);               
}

public function actionContact()
{
    $model = new ContactForm();
    if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
        Yii::$app->session->setFlash('contactFormSubmitted');

        return $this->refresh();
    } else {
        return $this->render('contact', [
            'model' => $model,
            ]);
    }
}

public function actionAbout()
{
    return $this->render('about');
}
}
