<?php

namespace app\controllers;
use app\models\User;
use app\models\Users;
use yii\data\ActiveDataProvider;
use app\models\PostServices;
use app\models\PostSearch;

class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionProfile(){
        $this->layout = 'columnLeft';
        $searchModel = new PostSearch();
        $user_id = \Yii::$app->user->getID();
        $dataProvider = $searchModel->search(['owner'=>$user_id, 'active'=>'1']);
        $user = User::findIdentity($user_id);
        return $this->render('profile', [
            'user'=>$user,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

}
