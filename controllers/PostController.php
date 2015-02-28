<?php

namespace app\controllers;

use Yii;
use app\models\PostServices;
use app\models\PostRatings;
use app\models\PostSearch;
use app\models\Notification;
use app\models\PostViews;
use app\models\PostOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PostCategory;
use app\models\Users;
use yii\web\UploadedFile;
use yii\easyimage\EasyImage;
/**
 * PostController implements the CRUD actions for PostServices model.
 */
class PostController extends Controller
{
    public $layout = 'columnLeft';

    public function behaviors()
    {
        return [
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        'delete' => ['post'],
        ],
        ],
        ];
    }

    /**
     * Lists all PostServices models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Displays a single PostServices model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $slug)
    {
        $this->layout = 'columnLeft';
        $model = $this->findModel($id);
        $user_id = \Yii::$app->user->getId();
        $likes = PostRatings::find()->where(['post_id'=>$model->post_id, 'rating'=>'1'])->count();
        $dislikes = PostRatings::find()->where(['post_id'=>$model->post_id, 'rating'=>'0'])->count();
        $exists = PostRatings::find()->where(['user_id'=> $user_id, 'post_id'=>$id])->orderBy('datetimestamp DESC')->one();
        $like_e = false;
        $dislike_e = false;
        if(!empty($exists)){
            if($exists->rating == 1){
                $like_e = true;
                $dislike_e = false;
            }else{
                $dislike_e = true;
                $like_e = false;
            }
        }
        $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
        if(!$pageWasRefreshed && $model->owner_id != Yii::$app->user->getId()){
            $this->increaseView($id);            
        }       
        return $this->render('view', [
            'model' =>  $model,
            'likes' => $likes,
            'dislikes' => $dislikes,
            'like_e' => $like_e,
            'dislike_e' => $dislike_e,
            ]);
    }

    private function increaseView($post_id){
        $viewCount = PostViews::find()->where(['post_id'=>$post_id])->one();
        if(empty($viewCount)){
            $viewCount = new PostViews;
         $viewCount->post_id = $post_id;
         $viewCount->view_count = 1;
        }else{
            $viewCount->view_count += 1;
        }    
        if($viewCount->save()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Creates a new PostServices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $user_id = \Yii::$app->user->getID();
        $user = Users::find($user_id)->one();
        $categories = new PostCategory;
        $model = new PostServices();
        $categories = $categories->find()->all();
        $categoryList[''] = '--Select category--';
        foreach ($categories as $key => $category) {
            $categoryList[$category->category_id] = $category->category_name;
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->owner_id = $user_id;
            $model->currency = 'Rs.';
            $slug = preg_replace( "/^\.+|\.+$/", "", $model->title);
            $slug = explode(' ', strtolower($slug));
            foreach($slug as $key => $char){
                if ($key != sizeof($url)-1){
                    $model->slug .= $char . '-';
                }else{
                    $model->slug .= $char;
                }
            }
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $length = 8;
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }   
            $file = UploadedFile::getInstance($model, 'image_url');
            $ext = explode('.', $file->name);
            $model->image_url = $user_id . '_' . $randomString . '.' . $ext[count($ext)-1];
            $model->datetimestamp = date('Y-m-d H:i:s', time());
            $model->featured = 0;
            if($model->save()){
               $file->saveAs('images/services/' . $model->image_url);
               $file=Yii::getAlias('@app/web/images/services/'.$model->image_url); 
               $image=Yii::$app->image->load($file);
               $image->resize(1000,1000)->crop(800, 500)->save();
               \Yii::$app->getSession()->setFlash('message', 'Post created successfully. You are ready to make some money.');
               return $this->redirect(['user/dashboard']);
           }
       }
       return $this->render('create', [
        'model' => $model,
        'categories' => $categoryList,
        'user'=>$user,
        ]);

   }

    /**
     * Updates an existing PostServices model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $this->layout = 'columnLeft';
        $id = $_POST['post_id'];
        $model = $this->findModel($id);
        $user_id = \Yii::$app->user->getID();
        $image_url = $model->image_url;
        $categories = new PostCategory;
        $categories = $categories->find()->all();
        $categoryList[''] = '--Select category--';
        foreach ($categories as $key => $category) {
            $categoryList[$category->category_id] = $category->category_name;
        }
        if ($model->load(Yii::$app->request->post())) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $slug = preg_replace( "/^\.+|\.+$/", "", $model->title);
            $slug = explode(' ', strtolower($slug));
            $model->slug ='';
            foreach($slug as $key => $char){
                if ($key != sizeof($slug)-1){
                    $model->slug .= $char . '-';
                }else{
                    $model->slug .= $char;
                }
            } 
            $length = 8;
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }   
            $file = UploadedFile::getInstance($model, 'image_url');
            if(!empty($file)){
                $ext = explode('.', $file->name);
                $model->image_url = $user_id . '_' . $randomString . '.' . $ext[count($ext)-1];
                $file->saveAs('images/services/' . $model->image_url);
                $file=Yii::getAlias('@app/web/images/services/'.$model->image_url); 
                $image=Yii::$app->image->load($file);
                $dimension = getimagesize('images/services/' . $model->image_url);
                $width = $dimension[0];
                $height = $dimension[1];
                if($height > $width ){
                 $image->resize($width*2, $width*2)->crop(800, 500)->save();
             }else{
               $image->resize($height*1.5,$height*1.5)->crop(800, 500)->save();
           }
       }else{
        $model->image_url = $image_url;
    }
    if($model->save()){
        \Yii::$app->getSession()->setFlash('message', 'Post updated successfully.');
        return $this->redirect(['user/dashboard']);
    }
} else {
    return $this->render('update', [
        'model' => $model,
        'categories' => $categoryList,
        ]);
}
}

    /**
     * Deletes an existing PostServices model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PostServices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PostServices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PostServices::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRate(){
        if(isset($_GET['rating'])){
            $post_id = (int) $_GET['id'];
            $user_id = \Yii::$app->user->getID();
            $rating = (int) $_GET['rating'];
            $lcount = PostRatings::find()->where(['user_id'=> $user_id, 'post_id'=>$post_id, 'rating'=>'1'])->count();
            $dlcount = PostRatings::find()->where(['user_id'=> $user_id, 'post_id'=>$post_id, 'rating'=>'0'])->count();
            if($lcount == 0 && $dlcount == 0){
                $post = new PostRatings;
                $post->post_id = $post_id;
                $post->rating = $rating;
                $post->user_id = $user_id;
                $post->datetimestamp = date('Y-m-d H:i:s', time());
                if($post->save()){
                    $lcount = PostRatings::find()->where(['post_id'=>$post_id, 'rating'=>'1'])->count();
                    $dlcount = PostRatings::find()->where(['post_id'=>$post_id, 'rating'=>'0'])->count();
                    $response = ['likes'=>$lcount, 'dislikes'=>$dlcount, 'res'=>'true'];
                    echo json_encode($response);
                }else{
                    $response = ['res'=>'false'];
                    echo json_encode($response);
                }
            }elseif($lcount == 1 && $dlcount == 0 && $rating == 0){
               $postDelete = PostRatings::find()->where(['user_id'=>$user_id, 'post_id'=>$post_id, 'rating'=>'1'])->one();
               $post = new PostRatings;
               $post->post_id = $post_id;
               $post->rating = $rating;
               $post->user_id = $user_id;
               $post->datetimestamp = date('Y-m-d H:i:s', time());
               if($post->save() && $postDelete->delete()){
                                    $lcount = PostRatings::find()->where(['post_id'=>$post_id, 'rating'=>'1'])->count();
                    $dlcount = PostRatings::find()->where(['post_id'=>$post_id, 'rating'=>'0'])->count();
                    $response = ['likes'=>$lcount, 'dislikes'=>$dlcount, 'res'=>'true'];
                    echo json_encode($response);

            }else{
                $response = ['res'=>'false'];
                    echo json_encode($response);
            }
        }elseif($lcount == 0 && $dlcount == 1 && $rating == 1){
            $postDelete = PostRatings::find()->where(['user_id'=>$user_id, 'post_id'=>$post_id, 'rating'=>'0'])->one();
            $post = new PostRatings;
            $post->post_id = $post_id;
            $post->rating = $rating;
            $post->user_id = $user_id;
            $post->datetimestamp = date('Y-m-d H:i:s', time());
            if($post->save() && $postDelete->delete()){
                $lcount = PostRatings::find()->where(['post_id'=>$post_id, 'rating'=>'1'])->count();
                    $dlcount = PostRatings::find()->where(['post_id'=>$post_id, 'rating'=>'0'])->count();
                    $response = ['likes'=>$lcount, 'dislikes'=>$dlcount, 'res'=>'true'];
                    echo json_encode($response);
            }else{
                $response = ['res'=>'false'];
                    echo json_encode($response);
            }
        }
    }
}

public function actionOrder($id){
    $post = $this->findModel($id);
    $order = new PostOrder;
    if ($order->load(Yii::$app->request->post())) {
        $order->post_id = $id;
        $order->user_id = \Yii::$app->user->getId();
        $order->datetimestamp =date('Y-m-d H:i:s', time());
        $order->status = 1;
        if($order->validate()){
            $notification = new Notification;
            $notification->user_id = PostServices::find()->where(['post_id'=>$id])->one()->owner_id;
            $notification->source = $order->user_id;
            $notification->notification = Users::find()->where(['user_id'=>Yii::$app->user->getId()])->one()->display_name . ' ordered your service.';
            $notification->datetimestamp = $order->datetimestamp;
            $notification->type = 'order';
            $notification->post_id = $order->post_id;
            if($notification->save() && $order->save()){
                Yii::$app->session->setFlash('message', 'Order placed successfully');
                return $this->redirect(['user/dashboard']);
            }
        }
    }
    return $this->render('order', ['post'=>$post, 'model'=>$order]);
}
}
