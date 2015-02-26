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
        $posts = PostServices::find()->where(['owner_id'=>$user_id])->all();
        $user = User::findIdentity($user_id);
        return $this->render('profile', [
            'user'=>$user,
            'posts'=>$posts,
            ]);
    }

}
