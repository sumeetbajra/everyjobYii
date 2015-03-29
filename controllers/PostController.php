<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\CJSON;
use yii\filters\AccessControl;
use app\models\PostServices;
use app\models\PostRatings;
use app\models\PostSearch;
use app\models\TaskStatus;
use app\models\TaskFiles;
use app\models\Comments;
use app\models\AcceptedOrders;
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
use app\models\RejectedOrder;
use yii\data\ActiveDataProvider;
/**
 * PostController implements the CRUD actions for PostServices model.
 */
class PostController extends Controller
{
    public $layout = 'columnLeft';

    public function behaviors()
    {
        return [
        'access' => [
        'class' => AccessControl::className(),
        //'only' => ['logout'],
        'rules' => [
        [
        'actions' => ['logout', 'order', 'create', 'update', 'delete', 'rate', 'vieworder', 'view', 'processorder', 'rejectedorder', 'acceptorder', 'acceptedorder', 'taskdashboard', 'completetask', 'requestcompletion', 'rejectcompletionrequest'],
        'allow' => true,
        'roles' => ['@'],
        ],
         [
        'actions' => ['posts', 'loadpost'],
        'allow' => true,
        ],
        ],
        ],
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
        $comments = Comments::find()->joinWith('commentBy')->where(['comments.user_id'=>$model->owner_id])->all();
        return $this->render('view', [
            'model' =>  $model,
            'likes' => $likes,
            'dislikes' => $dislikes,
            'like_e' => $like_e,
            'dislike_e' => $dislike_e,
            'comments'=>$comments,
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
        $user_id = \Yii::$app->user->getId();
        $user = Users::findOne($user_id);
        $categories = new PostCategory;
        $model = new PostServices();
        $categories = $categories->find()->all();
        $categoryList[''] = '--Select category--';
        foreach ($categories as $key => $category) {
            $categoryList[$category->category_id] = $category->category_name;
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->description = nl2br($model->description);
            $model->owner_id = $user_id;
            $model->currency = 'Rs.';
            $slug = preg_replace( "/^\.+|\.+$/", "", $model->title);
            $slug = explode(' ', strtolower($slug));
            foreach($slug as $key => $char){
                if ($key != sizeof($slug)-1){
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
            if(!empty($file)){
                $ext = explode('.', $file->name);
                $model->image_url = $user_id . '_' . $randomString . '.' . $ext[count($ext)-1];
                $model->datetimestamp = date('Y-m-d H:i:s', time());
                $model->featured = 0;
            }
            if($model->save()){
                if(!empty($file)){
                    $file->saveAs('images/services/' . $model->image_url);
                    $file=Yii::getAlias('@app/web/images/services/'.$model->image_url); 
                    $image=Yii::$app->image->load($file);
                    $dimension = getimagesize('images/services/' . $model->image_url);
                    $width = $dimension[0];
                    $height = $dimension[1];
                    if($height > $width ){
                        $image->resize($width*2, $width*2)->crop(800, 500)->save();
                    }else{
                        $image->resize($height*2,$height*2)->crop(800, 500)->save();
                    }
                }
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
        if(isset($_POST['post_id'])){
            $id = (int) $_POST['post_id'];
            Yii::$app->session['post_id'] = $id;
        }else{
            $id =  Yii::$app->session['post_id'];
        }
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
                 $image->resize($height*2,$height*2)->crop(800, 500)->save();
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

public function actionVieworder($id){
    $post_id = (int) $id;
    $model = $this->findModel($post_id);
    $orders = PostOrder::find()->where('type != "Completed" AND type != "Rejected" AND post_id = '.$post_id.' AND status =1')->all();
    $number = count($orders);
    if($model->owner_id == \Yii::$app->user->getId()){
        return $this->render('viewOrder', ['model'=>$model, 'orders'=>$orders, 'number'=>$number]);
    }else{
        return $this->redirect('site/error');
    }
}

public function actionRejectedorder($id){
    $user_id = (int) $id;
    $orders = PostOrder::find()->joinWith('rejected')->where('rejected_order.reason != ""', ['user_id'=>$id, 'status'=>'1'])->all();
    $number = count($orders);
    return $this->render('rejectedOrder', ['rejected'=>$orders, 'number'=>$number]);
}

public function actionAcceptedorder($id){
    $user_id = (int) $id;
    $orders = PostOrder::find()->joinWith('accepted')->where('accepted_orders.post_id != "" AND accepted_orders.payment = "unpaid" AND post_order.user_id = '.$id.' AND status = 1')->all();
    $number = count($orders);
    return $this->render('acceptedOrder', ['accepted'=>$orders, 'number'=>$number]);
}

public function actionAcceptorder(){
    $model = new AcceptedOrders;
    if (isset($_POST['order_id'])) {
        $model->order_id = (int) $_POST['order_id'];
        $order = PostOrder::find()->joinWith('post')->where(['order_id'=>$model->order_id])->one();
        $model->user_id = $order->user_id;
        $model->delivery_date = date('Y-m-d H:i:s', time() + ($order->post->max_delivery_days*86400));
        $model->post_id = PostOrder::findOne($model->order_id)->post_id;
        $model->datetimestamp = date('Y-m-d H:i:s', time());
        $model->payment = 'unpaid';
        if($model->validate()){
            $notification = new Notification;
            $notification->user_id = $model->user_id;
            $notification->source = \Yii::$app->user->getId();
            $notification->notification = Users::find()->where(['user_id'=>Yii::$app->user->getId()])->one()->display_name . ' accepted your service order.';
            $notification->datetimestamp = date('Y-m-d H:i:s', time());
            $notification->type = 'order_accept';
            $notification->post_id = $model->post_id;
            $old = Notification::find()->where(['type'=>'order', 'post_id'=>$notification->post_id, 'user_id'=>Yii::$app->user->getId()])->one();
            $old->status = 0;
            if($notification->save() && $model->save() && $old->save()){
                $order = PostOrder::findOne($model->order_id);
                $order->type = 'accepted';
                $order->save();
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }else{
            print_r($model->getErrors());
        }
    }
}

public function actionProcessorder(){
    $model = new RejectedOrder;
    if ($model->load(Yii::$app->request->post())) {
        $post_id = (int) $_POST['post_id'];
        $model->datetimestamp = date('Y-m-d H:i:s', time());
        if($model->validate()){
            $notification = new Notification;
            $notification->user_id = (int) $_POST['user_id'];
            $notification->source = \Yii::$app->user->getId();
            $notification->notification = Users::find()->where(['user_id'=>Yii::$app->user->getId()])->one()->display_name . ' rejected your service order.';
            $notification->datetimestamp = $model->datetimestamp;
            $notification->type = 'order_reject';
            $notification->post_id = $_POST['post_id'];
            $old = Notification::find()->where(['type'=>'order', 'post_id'=>$notification->post_id, 'user_id'=>\Yii::$app->user->getId()])->one();
            $old->status = 0;
            $order = PostOrder::findOne($model->order_id);
            $order->type = 'Rejected';
            if($notification->save() && $model->save() && $old->save() && $order->save()){
                \Yii::$app->session->setFlash('message', 'Order rejected successfully');
                return $this->redirect(['post/vieworder/'. $post_id]);
            }
        }else{
            print_r($model->getErrors());
        }
    }
}

    /**
     * Taskboard for each accepted order
     */
    public function actionTaskdashboard($id){
        $order_id = (int) $id;
        $accepted = AcceptedOrders::findOne($id);
        $user_id = \Yii::$app->user->getId();
        $user = Users::findOne($user_id);
        $order = PostOrder::find()->with('post')->where(['order_id'=>$id])->one();
        $ds = DIRECTORY_SEPARATOR;  
        $storeFolder = '..' . $ds . 'web' . $ds . 'images' . $ds . 'task';   
        if (!empty($_FILES)) {
            $tempFile = $_FILES['file']['tmp_name'];                     
            $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  
            $temp = explode(".",$_FILES['file']['name']);
            $fileName = time() . '.' .end($temp);
            $targetFile =  $targetPath. $fileName; 
            if(move_uploaded_file($tempFile,$targetFile)){
             $status = new TaskStatus;
             $status ->order_id = $order_id;
             $status->user_id = $user_id;
             $status->status = $user->display_name . ' uploaded a new file';
             $status->datetimestamp = date('Y-m-d H:i:s', time());
             if($status->save()){
                $files = new TaskFiles;
                $files->status_id = $status->status_id;
                $files->file_url = $fileName;
                $files->save();
            }
        }
    }
    $status = new TaskStatus;
    if(!empty($order->datetimestamp) && $accepted->closed_date == '' && ($order->post->owner_id == $user_id || $order->user_id == $user_id)){
        if(\Yii::$app->request->post()){
            $status->order_id = $order_id;
            $status->user_id = $user_id;
            $status->status = \Yii::$app->request->post()['status'];
            $status->datetimestamp = date('Y-m-d H:i:s', time());
            if($status->save()){
                \Yii::$app->session->setFlash('message', 'Task status added successfully');
                return $this->redirect(['post/taskdashboard/'.$order_id]);
            }else{
                print_r($status->getErrors());
                exit;
            }
        }
        $query = TaskStatus::find()->with('user')->with('taskFiles')->where(['order_id'=>$id])->orderBy('datetimestamp DESC');
        $dataProvider = new ActiveDataProvider(['query'=>$query, 'pagination' => [
            'pageSize' => 5,
            ]]);
        return $this->render('dashboard', ['order'=>$order, 'user'=>$user, 'dataProvider'=>$dataProvider, 'status'=>$status]);
    }else{
        return $this->render('../site/error', ['name'=>'Page Not Found', 'message'=>'Sorry, the page you were looking for was not found. Sorry for your inconvenience.']);
    }
}

    /**
     * action to handle form post
     * change status of order to complete
     * redirect it to user dashboard
     */
    public function actionCompletetask(){
        $comment = new Comments;
        if(isset($_POST['stars'])){
            $order_id = (int) $_POST['order_id'];
            $user_id = (int) $_POST['user_id'];
            $order = PostOrder::findOne($order_id);
            $accepted = AcceptedOrders::findOne($order_id);
            $comment->comment = $_POST['comment'];
            $comment->stars = (int) $_POST['stars'];
            $comment->datetimestamp = date('Y-m-d H:i:s', time());
            $comment->comment_by = \Yii::$app->user->getId();
            $comment->user_id = $user_id;
            $order->type = 'Completed';
            $accepted->closed_date = date('Y-m-d H:i:s', time());
            if($comment->stars != 0 && $order->save() && $comment->save() && $accepted->save()){
                $notification = new Notification;
                $notification->user_id = $user_id;
                $notification->source = $comment->comment_by;
                $notification->notification = Users::findOne($comment->comment_by)->display_name . ' changed the status of task to completed';
                $notification->datetimestamp = $comment->datetimestamp;
                $notification->type = 'task-completed';
                $notification->post_id = $order->post_id;
                $notification->save();
                \Yii::$app->session->setFlash('message', 'Task closed successfully');
                return $this->redirect(Url::to(['user/dashboard']));
            }else{
                \Yii::$app->session->setFlash('message', 'You must leave a rating');
                return $this->redirect(Url::to(['post/taskdashboard/'.$order_id]));
            }
        }
    }

    /**
     * handles ajax request
     * request the buyer to change the status of task to complete 
     * or close the task
     * handles post request of the order id
     * @return [string] [true or false based on the result]
     */
    public function actionRequestcompletion(){
        if(isset($_GET['id'])){
            $id = (int) $_GET['id'];
            $accepted = AcceptedOrders::findOne($id);
            $accepted->complete_request = 1;
            $accepted->complete_request_date = date('Y-m-d H:i:s', time());
            if($accepted->validate()){
              $notification = new Notification;
              $notification->user_id = $accepted->user_id;
              $notification->source = \Yii::$app->user->getId();
              $notification->notification = Users::findOne(Yii::$app->user->getId())->display_name . ' requested you to close the task.';
              $notification->datetimestamp = date('Y-m-d H:i:s', time());
              $notification->type = 'close_task_request';
              $notification->post_id = $accepted->order_id;
              if($notification->validate()){
                $accepted->save();
                $notification->save();
                echo "true";
                }else{
                    echo "false";
                }
            }else{
                echo "false";
            }
        }
    }

    public function actionRejectcompletionrequest($id){
        $id = (int) $id;
        $accepted = AcceptedOrders::findOne($id);
        $accepted->complete_request = 3;
        $accepted->complete_request_date = date('Y-m-d H:i:s', time());
        if($accepted->validate()){
          $notification = new Notification;
          $notification->user_id = PostServices::findOne($accepted->post_id)->owner_id;
          $notification->source = \Yii::$app->user->getId();
          $notification->notification = Users::findOne(Yii::$app->user->getId())->display_name . ' rejected your request to close the task.';
          $notification->datetimestamp = date('Y-m-d H:i:s', time());
          $notification->type = 'reject_close_task_request';
          $notification->post_id = $accepted->order_id;
          if($notification->validate()){
            $accepted->save();
            $notification->save();
            Yii::$app->session->setFlash('message', 'You have rejected seller\'s request to close the task');
            return $this->redirect(Url::to(['post/taskdashboard/'.$id]));
        }
    }
    Yii::$app->session->setFlash('message', 'Oops!! Something went wrong. Try again later.');
    return $this->redirect(Url::to(['post/taskdashboard/'.$id]));
    }

    public function actionPosts($sort = 'view', $q = ''){
        $this->layout = 'noSideMenu';
        $searchKeys = str_replace(' ', '+', $q);
        if(!empty($q)){
            $q = explode(' ', $q);
            $search = 'active = 1 AND ';
            foreach ($q as $key => $keyword) {
                if($key != count($q) - 1){
                    $search .= 'tags LIKE "%' . htmlentities($keyword) . '%" OR ';
                }else{
                    $search .= 'tags LIKE "%' . htmlentities($keyword) . '%"';
                }
            }
            $posts = PostServices::find()->joinWith('views')->where($search)->orderBy('post_views.view_count DESC')->all();
        }else{
            $posts = PostServices::find()->joinWith('views')->where(['active'=>'1'])->orderBy('post_views.view_count DESC')->all();
        }
        $post = new PostServices;
        $posts = $post->sort($posts, $sort);
        return $this->render('posts', ['posts'=>$posts, 'sort'=>$sort, 'keywords'=>$searchKeys]);
    }

    public function actionLoadpost($sort, $page){
        $page = (int) $page;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $posts = PostServices::find()->joinWith('views')->where(['active'=>'1'])->orderBy('post_views.view_count DESC')->all();
        $post = new PostServices;
        $ratings = new PostRatings;
        $posts = $post->sort($posts, $sort, $page);
         foreach ($posts as $key => $post) {
                    $data[$key]['featured'] =  $post->featured;
                    $data[$key]['image_url'] = $post->image_url;
                    $data[$key]['currency'] = $post->currency;
                    $data[$key]['price'] = $post->price;
                    $data[$key]['title'] = $post->title;
                    $data[$key]['display_name'] = Users::findOne($post->owner_id)->display_name;
                    $data[$key]['soldCount'] = \Yii::$app->function->getSoldCount($post->post_id);
                    $data[$key]['viewCount'] = (PostViews::find()->where(['post_id'=>$post->post_id])->count() == 0 ? 0 : PostViews::find()->where(['post_id'=>$post->post_id])->one()->view_count); 
                    $data[$key]['likes'] = $ratings->postRating($post->post_id)['likes'];
                    $data[$key]['dislikes'] = $ratings->postRating($post->post_id)['dislikes'];
                    $data[$key]['id'] = $post->post_id;
        }
        echo json_encode($data, true);
    }
}
