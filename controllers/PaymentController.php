<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\User;
use app\models\Users;
use app\models\Transaction;
	
use app\models\Error;
use app\models\PostOrder;
use app\models\PostServices;
use app\models\AcceptedOrders;
use app\models\Notification;

class PaymentController extends Controller
{
	public $enableCsrfValidation = false;

	public function actionPaypalipn(){
		include(Yii::getAlias('@vendor/Paypal/Paypal_IPN.php'));
	}

	public function actionHellopaisa()
	{
		/*
		* Hello-Paisa Merchant API: PHP-sample code.
		*/

		// import the nusoap library.
		include(Yii::getAlias('@vendor/nusoap/lib/nusoap.php'));
		$transactionID = "";

		//crete a client object for the Web-Service (i.e Hello Paisa Payment API)
		include ('http://110.44.114.210:8080/PaymentHandler/coreApi?wsdl');
		$client = new nusoap_client('http://110.44.114.210:8080/PaymentHandler/coreApi?wsdl',TRUE);

		// defining the request parameters
		$requestParameters = array('id' => '1234',
			'mobile' => '9841780631',
			'pin' => '1234',
			'serviceCode' => '23', // payment service code
			'value' => '10.0' // Transaction Amount
			);

		// Initiate the transaction request,
		$resultRequest = $client->call("initiatePayment", array('arg0'=> $requestParameters));
		// Check for a fault
		if ($client->fault) {
			echo '<h2>Fault</h2><pre>';
			print_r($resultRequest);
			echo '</pre>';
		} else {
		// Check for errors
			$err = $client->getError();
			if ($err) {
		// Display the error
				echo '<h2>Error</h2><pre>' . $err . '</pre>';
			} else {
		// Display the result
		//result of the transaction request
				echo '<h2>Result</h2><pre>';
				print_r($resultRequest);

				$requestResponse[] = 'HelloPaisa';
				foreach($resultRequest['return'] as $requestReturn)
				{
		// print_r($r);
					array_push($requestResponse, $requestReturn);
					echo '</br>';
				}
				var_dump($requestResponse);
				$transactionID = $requestResponse[2];
				echo $transactionID;

			}
		}

		// Verify the transaction ,

		//Note: It's recommended to check the verification after about 30 seconds, and continue to check //verification until you get a concrete response code  or some timeout.

		//eg. response code of: 9004,9005,9006 and validity = true, indicates that the call is in progress.
		$transactionID = 'id-returned-from-the-transaction-request';
		// call verify method with the parameter of the transaction-id returned from the transaction-request.
		$resultVerifyTransaction = $client->call("verifyTransaction",array('arg0' => $transactionID));

		//array to hold the response from the verification
		$responseVerify[] = 'CheckVerification';

		foreach($resultVerifyTransaction['return'] as $verifyReturn)
		{
			array_push($responseVerify, $verifyReturn);
		}
		// here is the outputs from the verifications.
		$validity = $responseVerify[3];
		$error_description = $responseVerify[1];
		if($error_description == '0' && $validity == 'true')
		{
			echo 'Transaction Success';
		}
		else
		{
			echo 'Transaction Failed';
		}
		var_dump($responseVerify);
	}

	public function actionTest()
	{

	$item_number = '5';
	$item_name = 'Test';
	$custom = '1';
	$payment_status = 'completed';
	$payment_amount = '23';
	$payment_currency = 'USD';
	$txn_id = 'SDDF';
	$receiver_email = 'niti@gmail.com';
	$payer_email = 'jyotsna@gmail.com';
	
	$model = new Transaction;
	$model->transaction_id = $txn_id;
	$model->order_id = $custom;
	$model->post_id = $item_number;
	$model->post_price = PostServices::findOne($model->post_id)->price;
	$model->amount = $payment_amount;
	$model->currency = $payment_currency;
	$model->payment_status = 'completed';
	$model->payer_email = $payer_email;
	$model->datetimestamp = date('Y-m-d H:i:s', time());
	$accepted = AcceptedOrders::findOne($model->order_id);
	$accepted->payment = 'paid';	
	
	$notification = new Notification;
	$notification->user_id = PostServices::findOne($model->post_id)->owner_id;
	$user = Users::find()->where(['email'=>$model->payer_email])->one();
	$notification->source = $user->user_id;
	$notification->notification = $user->display_name . ' completed the payment for the order.';
	$notification->datetimestamp = date('Y-m-d H:i:s', time());
	$notification->type = 'payment_complete';
	$notification->post_id = $model->post_id;
	$old = Notification::find()->where(['type'=>'order_accept', 'post_id'=>$notification->post_id, 'user_id'=>$user->user_id])->one();
	$old->status = 0;
	
	if($model->validate() && $accepted->validate() && $notification->validate() && $old->validate()){
		$notification->save();
		$old->save();
		$model->save();
		$accepted->save();
	}else{
		$error = new Error;
		$error->log = serialize($notification->getErrors());
		$error->save();
	}
	}
}