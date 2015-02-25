<?php

namespace app\controllers;
use app\models\User;
use app\models\Users;
use yii\data\ActiveDataProvider;

class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionProfile(){
    	$this->layout = 'columnLeft';
    	$user_id = \Yii::$app->user->getID();
    	$user = Users::find($user_id)->one();
    	return $this->render('profile', ['user'=>$user]);
    }

}
