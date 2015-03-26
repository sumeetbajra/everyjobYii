<?php

namespace app\controllers;
use app\models\PostServices;
use app\models\PostRatings;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class AdminController extends \yii\web\Controller
{
	public function actionIndex()
	{
		return $this->render('dashboard');
	}

	public function actionLogin()
	{
		return $this->render('login');
	}

	public function actionPosts($sort = 'views', $page = '1'){
		$posts = PostServices::find()->joinWith('views')->where(['active'=>'1'])->orderBy('post_views.view_count DESC')->all();
		$ratings = new PostRatings;
		$limit = 9;
    		// How many pages will there be
		$pages = ceil(count($posts) / $limit);
		$inset = ((int) $page - 1) * $limit;
		$offset = (int) $page * $limit;
		$posts = array_slice($posts, $inset, $offset);
		if ($sort == 'likes') {
			foreach ($posts as $key => $post) {
				$post->likes = $ratings->postRating($post->post_id)['likes'];
			}
			usort($posts, function($a, $b) {
				return $b->likes - $a->likes;
			});
		}elseif ($sort == 'dislike') {
			foreach ($posts as $key => $post) {
				$post->dislikes = $ratings->postRating($post->post_id)['dislikes'];
			}
			usort($posts, function($a, $b) {
				return $b->dislikes - $a->dislikes;
			});
		}elseif ($sort == 'sold') {
			foreach ($posts as $key => $post) {
				$post->sold = \Yii::$app->function->getSoldCount($post->post_id);
			}
			usort($posts, function($a, $b) {
				return $b->sold - $a->sold;
			});

		}
		return $this->render('posts', ['posts'=>$posts, 'pages'=>$pages]);
	}

	public function actionAddtofeatured($id){
		$post = PostServices::findOne($id);
		if($post->featured == 1){
			$post->featured = 0;
		}else{
			$post->featured = 1;
		}
		if($post->save()){
			\Yii::$app->session->setFlash('message', 'Post added to featured succesfully');
			return $this->redirect(Url::to(['admin/posts']));
		}
	}

	public function actionViewusers(){
		$users = Users::find()->where(['active'=>1])->all();
		return $this->render('viewUsers', ['users'=>$users]);
	}

}
