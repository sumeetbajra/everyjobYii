<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\PostRatings;
use app\models\Notification;
use app\models\ContactForm;
use app\models\User;
use app\models\PostServices;
use app\models\Users;
use yii\web\UploadedFile;
use yii\easyimage\EasyImage;

class SiteController extends Controller
{
    public $layout='columnLeft';
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
        //'logout' => ['post'],
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

    public function actionMail($email, $token){      
        return Yii::$app->mailer->compose()
        ->setTo($email)
        ->setFrom(['mail-noreply@example.com' => 'Everyjob'])
        ->setSubject('Everyjob Account activation')
        ->setHtmlBody('Please click  <a href="localhost/everyjobSite/web/site/activate?token='.$token.'">here</a> to activate your account. <br><br> Thank you, <br>Everyjob Team')
        ->send();
    }

    public function actionActivate($token){
        $token = htmlentities($token);
        $token = preg_replace('/[^-a-zA-Z0-9_]/', '', $token);
        $user = Users::find()->where(['accessToken'=>$token, 'verified'=>'0'])->one();
        if(!empty($user)){
            $hourdiff = round((strtotime($user->created_at) - time())/3600, 1);
            if($hourdiff < 24){
                $user->verified = 1;
                if($user->save()){
                    $model = new Users;
                   return $this->render('login', ['model'=>$model]);
               }
           }else{
              $message = 'It seems that your activation link has expired. Please click here to resend new activation link to your email.';
                $name = 'Token Expired';
                return $this->render('error', ['message'=>$message, 'name'=>$name]);
           }
       }else{
        return $this->goHome();
    }

    }

    public function actionIndex(){
        $this->layout = 'master';
        $model = new LoginForm();
        $posts = PostServices::find()->joinWith('views')->orderBy('view_count DESC')->limit(8)->all();
        $ratings = new PostRatings;
        return $this->render('index', ['model'=>$model, 'posts'=>$posts, 'ratings'=>$ratings]);
    }

    public function actionLogin()
    {
        $this->layout = 'noSideMenu';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = Users::findOne(\Yii::$app->user->getId());
            if($user->verified == 0){
                Yii::$app->user->logout();
                $message = 'Your account must be email verified in order to login. Please follow the verification link sent to your email address.';
                $name = 'Account unverified';
                return $this->render('error', ['message'=>$message, 'name'=>$name]);
            }elseif($user->authKey == 'admin'){
                return $this->redirect(['/admin']);
            }else{
                return $this->redirect(['user/dashboard']);
            }
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
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"); 
        $model = new Users;
        if($model->load(Yii::$app->request->post())){
            if($model->password == $_POST['re_password']){
                $model->created_at = date('Y-m-d H:i:s', time());
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $length = 8;
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }   
                $model->address = $_POST['city'] . ', ' . $countries[$_POST['country']];
                $file = UploadedFile::getInstance($model, 'profilePic');
                $ext = explode('.', $file->name);
                $model->profilePic = $randomString . '.' . $ext[count($ext)-1];
            $token = array(); //remember to declare $pass as an array
            $alphaLength = strlen($characters) - 1; //put the length -1 in cache
            for ($i = 0; $i < 32; $i++) {
                $n = rand(0, $alphaLength);
                $token[] = $characters[$n];
            }
                $token = implode($token); //turn the array into a string
                $model->accessToken = $token;
                if($model->save()){
                   Yii::$app->mailer->compose()
                   ->setTo($model->email)
                   ->setFrom(['mail-noreply@example.com' => 'Everyjob'])
                   ->setSubject('Everyjob Account activation')
                   ->setHtmlBody('Please click  <a href="localhost/everyjobSite/web/site/activate?token='.$token.'">here</a> to activate your account. <br><br> Thank you, <br>Everyjob Team')
                   ->send();
                    $file->saveAs('images/users/' . $model->profilePic);
                    $file=Yii::getAlias('@app/web/images/users/'.$model->profilePic); 
                    $image=Yii::$app->image->load($file);
                    $image->resize(800,800)->crop(500, 500)->save();
                    $message = 'An activation link has been sent to your email address. Please follow that link and sign in in order to activate your account.';
                $name = 'Account Activation';
                return $this->render('error', ['message'=>$message, 'name'=>$name]);
                }
            }else{
                $model->addError('password', 'The passwords do not match');
            }     
        }
        return $this->render('register1', ['model'=>$model, 'countries'=>$countries]);               
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
        $this->layout = 'master';
        return $this->render('about');
    }

    public function actionNotification(){
        $user_id = \Yii::$app->user->getId();
        $user = Users::find()->where(['user_id'=>$user_id])->one();
        $notification = Notification::find()->where(['user_id'=>\Yii::$app->user->getId(), 'status'=>1])->orderBy('datetimestamp DESC')->all();
        return $this->render('notification', ['notifications'=>$notification, 'user'=>$user]);   
    }
}
