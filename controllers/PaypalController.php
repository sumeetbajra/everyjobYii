<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\User;
use app\models\Users;
use app\models\Transaction;

class PaypalController extends Controller
{
	public $enableCsrfValidation = false;

	public function actionPaypalipn(){
		include(Yii::getAlias('@vendor/Paypal/Paypal_IPN.php'));
	}

}