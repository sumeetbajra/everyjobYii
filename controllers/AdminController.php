<?php

namespace app\controllers;
use app\models\PostServices;
use app\models\PostRatings;
use app\models\Users;
use app\models\Message;
use app\models\Transaction;
use app\models\FlagReports;
use app\models\Comments;
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
		$message = new Message;
		$users = Users::find()->where(['active'=>1])->all();
		return $this->render('viewUsers', ['users'=>$users, 'model'=>$message]);
	}

	public function actionUser($id){
		$id = (int) $id;
		$user = Users::find()->joinWith('posts')->where(['users.user_id' => $id])->one();
		$comments = Comments::find()->joinWith('commentBy')->where(['comments.user_id'=>$id])->all();
		return $this->render('user', ['user'=>$user, 'comments'=>$comments]);
	}

	public function actionUserreports(){
		$reports = FlagReports::find()->joinWith('user')->where(['flag_reports.active'=>'1'])->all();
		$model = new Message;
		return $this->render('userReports', ['reports'=>$reports, 'model'=>$model]);
	}

	public function actionClosereport($id){
		$id = (int) $id;
		$report = FlagReports::findOne($id);
		if(!empty($report)){
			$report->active = 0;
			if($report->save()){
				\Yii::$app->session->setFlash('message', 'The report closed succesfully.');
				return $this->redirect(Url::to(['/admin/userreports']));
			}
		}
	}

	public function actionMessage($id){
		$id = (int) $id;
		$message = new Message();
		if(\Yii::$app->request->post() && $message->load(\Yii::$app->request->post())){
			$message->from_user = '0';
			$message->datetimestamp = date('Y-m-d H:i:s', time());
			$message->thread_id = 0;
			if($message->save()){
				$message->thread_id = $message->message_id;
				$message->save();
				\Yii::$app->session->setFlash('message', 'Message sent succesfully.');
				return $this->redirect(\Yii::$app->request->referrer);
			}else{
				print_r($message->getErrors());
				exit;
				\Yii::$app->session->setFlash('error', 'Please specify subject or message.');
				return $this->redirect(\Yii::$app->request->referrer);
			}
		}
	}

	public function actionWithdrawrequests(){
		$transaction = Transaction::find()->joinWith('withdraw')->joinWith('post')->where(['complete'=>'0'])->all();
		return $this->render('withdraw', ['transaction'=>$transaction]);
	}

	public function actionListposts(){
		$posts = PostServices::find()->joinWith('views')->where(['active'=>'1'])->all();
		return $this->render('listPosts', ['posts'=>$posts]);
	}

	public function actionDeletepost(){
		$a = true;
		if(isset($_GET['posts']) && isset($_GET['action'])){
			$posts = $_GET['posts'];
			$action = htmlentities($_GET['action']);
			foreach ($posts as $key => $post) {
				$p = PostServices::findOne((int) $post);
				if($action == 'delete'){
					$p->active = 0;
				}elseif($action == 'add'){
					$p->featured = 1;
				}else{
					$p->featured = 0;
				}				
				if($p->save()){
					$a = $a && true;
				}else{
					print_r($p->getErrors());
					$a = false;
				}
			}
			if($a){
				echo "true";
			}else{
				print_r($p->getErrors());
			}
		}
	}
}
