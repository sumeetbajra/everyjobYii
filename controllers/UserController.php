<?php

namespace app\controllers;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Notification;
use yii\helpers\Url;
use app\models\PostRatings;
use app\models\Users;
use app\models\AcceptedOrders;
use app\models\Comments;
use app\models\FlagReports;
use app\models\PostOrder;
use yii\data\ActiveDataProvider;
use app\models\PostServices;
use app\models\PostSearch;
use app\models\Message;
use yii\web\UploadedFile;
use yii\easyimage\EasyImage;

class UserController extends \yii\web\Controller
{

    public $layout =  'columnLeft';
    public function behaviors()
    {
        return [
        'access' => [
        'class' => AccessControl::className(),
        'rules' => [
        [
        'actions' => ['dashboard', 'profile', 'update', 'clearnotific', 'activetasks', 'sendmessage', 'inbox', 'conversation', 'deletemsg', 'orderedservices', 'reportuser'],
        'allow' => true,
        'roles' => ['@'],
        ],
        ],
        ],
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        //'logout' => ['post'],
        ],
        ],
        ];
    }

    public function actions(){
        return [
        'captcha' => [
        'class' => 'yii\captcha\CaptchaAction',
        ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * action to display dashboard for the user
     */
    public function actionDashboard(){
        $searchModel = new PostSearch();
        $user_id = \Yii::$app->user->getID();
        $posts = PostServices::find()->where(['owner_id'=>$user_id, 'active'=>'1'])->all();
        $user = User::findIdentity($user_id);
        return $this->render('dashboard', [
            'user'=>$user,
            'posts'=>$posts,
            ]);
    }

    /**
     * display user profile
     * @param  [string] $user [display name of the user]
     */
    public function actionProfile($user){
        $this->layout = 'master';
        $user = Users::find()->where(['display_name'=>$user])->one();
        $ratings = new PostRatings;
        $posts = PostServices::find()->where(['owner_id'=>$user->user_id, 'active'=>'1'])->all();
        $model = new Message;
        $comments = Comments::find()->joinWith('commentBy')->where(['comments.user_id'=>$user->user_id])->all();
        return $this->render('profile', [
            'user' => $user,
            'posts' => $posts,
            'ratings'=>$ratings,
            'model'=>$model,
            'comments' => $comments,
            ]);
    }

    /**
     * update user details
     */
    public function actionUpdate(){
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"); 
        $user_id = \Yii::$app->user->getId();
        $user = Users::find()->where(['user_id'=>$user_id])->one();
        $profilePic = $user->profilePic;
        if($user->load(\Yii::$app->request->post())){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $length = 8;
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }   
            $user->address = $_POST['city'] . ', ' . $countries[$_POST['country']];
            $file = UploadedFile::getInstance($user, 'profilePic');
            if(!empty($file)){
                $ext = explode('.', $file->name);
                $user->profilePic = $randomString . '.' . $ext[count($ext)-1];
            }else{
                $user->profilePic = $profilePic;
            }
            if($user->save()){
                if(!empty($file)){
                    $file->saveAs('images/users/' . $user->profilePic);
                    $file=\Yii::getAlias('@app/web/images/users/'.$user->profilePic); 
                    $image=\Yii::$app->image->load($file);
                    $image->resize(800,800)->crop(500, 500)->save();
                }
                \Yii::$app->session->setFlash('success', 'Profile updated successfully');
                return $this->redirect(Url::to(['user/dashboard']));
            }
        }
        return $this->render('update', [
            'model' => $user,
            'countries'=>$countries,
            ]);
    }

/**
 * in order to clear the notifications
 * changes the notification statuses to 0 (read)
 * process ajax request and send response
 */
public function actionClearnotific(){
    if(isset($_GET['id'])){
        $response = true;
        $notifications = Notification::find()->where(['user_id'=>(int) $_GET['id']])->all();
        foreach ($notifications as $key => $notification) {
            $notification->read = 1;
            if($notification->save()){
                $response = $response && true;
            }else{
                $response = false;
            }
        }
        if($response){
            echo "true";
        }
    }
}

/**
 * action to send message to other users
 */
public function actionSendmessage($user){
    $user_id = \Yii::$app->user->getId();
    $me = Users::find()->where(['user_id'=>$user_id])->one();
    $message = new Message;
    $to = Users::find()->where(['display_name'=>$user])->one();
    if($user == '' && count($to) == 0){
        return $this->redirect(['site/error']);
    }
    if($message->load(\Yii::$app->request->post())){
        $message->datetimestamp = date('Y-m-d H:i:s', time());
        $message->from_user = \Yii::$app->user->getId();
        if($message->save()){
            if(!isset($message->thread_id)){
                $sql = "UPDATE `message` SET `thread_id`= " . $message->message_id . " WHERE `message_id` = " . $message->message_id;
                $message = \Yii::$app->db->createCommand($sql)->execute();
            }
                \Yii::$app->session->setFlash('message', 'Message sent successfully');
                return $this->redirect(['user/dashboard']);
        }
    }
    return $this->render('sendMessage', ['model'=>$message, 'to'=>$to, 'user'=>$me]);
}

/**
 * action to display user inbox
 */
public function actionInbox(){
    $user_id = \Yii::$app->user->getId();
    $user = Users::find()->where(['user_id'=>$user_id])->one();
    //$messages = Message::find()->where(['to_user'=>$user_id])->orderBy('datetimestamp DESC')->all();
    $sql = "SELECT * FROM (SELECT * FROM message WHERE to_user = $user_id ORDER BY datetimestamp DESC) msg GROUP BY msg.thread_id ORDER BY msg.datetimestamp DESC";
    $messages = Message::findbySql($sql)->all();
    $sql = "SELECT * FROM (SELECT * FROM message WHERE from_user = $user_id ORDER BY datetimestamp DESC) msg GROUP BY msg.thread_id ORDER BY msg.datetimestamp DESC";
    $sent = Message::findbySql($sql)->all();
    return $this->render('messages', ['user'=>$user, 'messages'=>$messages, 'sent'=>$sent]);
}

/**
 * action to display user conversation
 * @param  [int] $id [id of the thread]
 */
public function actionConversation($id){
    $id = (int) $id;
    $message = Message::findOne($id);
    if(!empty($message)){
        $user_id = \Yii::$app->user->getId();
        $user = Users::find()->where(['user_id'=>$user_id])->one();
        $message = \Yii::$app->db->createCommand('UPDATE message SET read_m = 1 WHERE thread_id = :id AND from_user != :from_user');
        $message->bindValue(':id', $id);
        $message->bindValue(':from_user', \Yii::$app->user->getId());
        $message->execute();
        $messages = Message::find()->where(['thread_id'=>$id])->orderBy('datetimestamp DESC')->all();
        return $this->render('conversation', ['user'=>$user, 'messages'=>$messages]);
    }else{
        return $this->redirect(['site/error']);
    }
}

/**
 * page to display all the active orders/tasks
 * allows users to add comment in the task
 */
public function actionActivetasks(){
    $user_id = \Yii::$app->user->getID();
    $user = User::findIdentity($user_id);
    $message = new Message;
    $tasks = AcceptedOrders::find()->joinWith('posts')->joinWith('order')->where('post_services.owner_id = '.$user_id . ' AND accepted_orders.payment = "paid" AND post_order.type != "Completed"')->all();
    return $this->render('activeTasks', ['tasks'=>$tasks, 'user'=>$user, 'message'=>$message]);
}

/**
 * handle AJAX request and change the status of message to 0
 * doesnot delete the message from table but just hides it
 * @return [string] [true or false based on the success or failure]
 */
public function actionDeletemsg(){
    $user_id = \Yii::$app->user->getID();
    $user = User::findIdentity($user_id);
    $result = true;
    if(isset($_GET['id'])){
        $id = (int) $_GET['id'];
        foreach (Message::find()->where('thread_id = ' . $id . ' AND (from_user = ' . $user_id . ' OR to_user = ' . $user_id . ') AND status = 1')->each() as $message) {
            $message->status = 0;
            if($message->save()){
                $result = $result || true;
            }
        }
        if($result){
            echo "true";
        }else{
            echo "false";
        }
    }
}

/**
 * page to display all the active ordered services by the user
 */
public function actionOrderedservices(){
    $user_id = \Yii::$app->user->getID();
    $user = User::findIdentity($user_id);
    $orders = PostOrder::find()->joinWith('post')->where('user_id = ' . $user_id . ' AND type != "Cancelled" AND type != "Completed" AND type != "Rejected"');
    $received = PostOrder::find()->joinWith('post')->where('post_services.owner_id = ' . $user_id . ' AND type != "Cancelled" AND type != "Completed" AND type != "Rejected"');
    return $this->render('orderedServices', ['user'=>$user, 'orders'=>$orders, 'received'=>$received]);
}

public function actionReportuser(){
    $type = htmlentities($_GET['type']);
    $id = (int) $_GET['id'];
    $report = new FlagReports;
    $report->reported_by = \Yii::$app->user->getId();
    $report->user_id = $id;
    $report->report = $type;
    $report->datetimestamp = date('Y-m-d H:i:s', time());
    if($report->save()){
        echo "true";
    }else{
        echo "false";
    }
}
}
