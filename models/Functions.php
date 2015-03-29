<?php

/**
 * Created by Sumit Bajracharya
 * March 4 2015
 * Consists of various functions that are used in many places 
 */

namespace app\models;

class Functions{
	private $user_id;

	/**
	 * constructor in order to initialize the value of user_id 
	 * to the id of currently logged in user
	 */
	public function __construct(){
		$this->user_id = \Yii::$app->user->getId();
	}

	/**
	 * get the number unread notifications for the user
	 * @return [integer] [number of unread notifications]
	 */
	public function getNotificationCount(){
		$notificCount = Notification::find()->where(['user_id'=>$this->user_id, 'read'=>'0', 'status'=>1])->count();
		return $notificCount;
	}

	/**
	 * get the number of unread messages
	 * @return [integer] [number of unread messages]
	 */
	public function getMsgCount(){
		$msgCount = Message::find()->where(['to_user'=>$this->user_id, 'read_m'=>'0'])->count();
		return $msgCount;
	}

	/**
	 * get total amount of money spent by the user
	 * @return [decimal] [amount of money spent]
	 */
	public function getMoneySpent(){
		$sql = "SELECT SUM(t.post_price) as sum FROM `transaction` t JOIN `post_order` p ON t.order_id = p.order_id  WHERE p.user_id = ".$this->user_id;
		$spent = \Yii::$app->db->createCommand($sql)->queryAll();
		if(!isset($spent[0]['sum'])){
			return "0";
		}else{
			return $spent[0]['sum'];
		}
	}

	/**
	 * toal money available for withdraw
	 * @param [int] [id] id of the user
	 * @return [decimal] [amount]
	 */
	public function getMoneyForWithdraw($id = 0){
		if($id == 0){
			$id = $this->user_id;
		}
		$amount = 0;
		foreach (Transaction::find()->joinWith('order')->joinWith('post')->where('payment="paid" AND owner_id='.$id)->each() as $key => $value) {
			$amount += $value->post_price;
		}
		return $amount;
	}

	public function getCurrencyRate($currency = ''){
		return 0.01;
		/*$url = 'http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency=NPR&ToCurrency=USD';
		$xml = simpleXML_load_file($url,"SimpleXMLElement",LIBXML_NOCDATA);
		if($xml ===  FALSE)
		{
               			return 0.01;
		}
		else { 
			$rate = $xml;
			return $rate[0];
		}*/
	}
	/**
	 * get total number of active posts posted by the user
	 * @param [int] (optional) id of the user
	 * @return [int] [number of active posts]
	 */
	public function getPostedServices($id = 0){
		if($id == 0){
			$id = $this->user_id;
		}
		$posted = PostServices::find()->where(['owner_id'=>$id, 'active'=>'1'])->count();
		return $posted;
	}

	/**
	 * get total number of services bought by the user
	 * @param [int] (optional) id of the user
	 * @return [integer] [number of services bought by the user]
	 */
	public function getBoughtServices($id = 0){
		if($id == 0){
			$id = $this->user_id;
		}
		$sql = "SELECT t.transaction_id FROM `transaction` t JOIN `post_order` p ON t.order_id = p.order_id WHERE p.user_id = ".$id;
		$bought = Transaction::findBySql($sql)->all();
		return count($bought);
	}

	/**
	 * total number of active orders received for the service
	 * @param  [int] $id [id of the post]
	 * @return [int] [number of active orders]
	 */
	public function getOrderCount($id){
		$orderCount = PostOrder::find()->where(['type'=>'Awaiting approval', 'status'=>'1', 'post_id'=>$id])->count();
		return $orderCount;
	}

	/**
	 * Returns the time in ago format. eg: 2 hours ago, 3 days ago
	 * @param  [datetime] $date [date time to be converted]
	 * @return [string]       [date in ago format]
	 */
	public  function getAgoTime($date){
	if(empty($date)) {
		return "No date provided";
	}
	$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	$lengths = array("60","60","24","7","4.35","12","10");
	$now = time();
	$unix_date = strtotime($date);
	// check validity of date
	if(empty($unix_date)) {
		return "Bad date";
	}
	// is it future date or past date
	if($now > $unix_date) {
		$difference = $now - $unix_date;
		$tense = "ago";
	} else {
		$difference = $unix_date - $now;
		$tense = "from now";}
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
		$difference = round($difference);
		if($difference != 1) {
			$periods[$j].= "s";
		}
		return "$difference $periods[$j] {$tense}";
	}

	/**
	 * method to get number of sold services by the user
	 * @param  [int] $id [id of the user]
	 * @return [int]     [number of services]
	 */
	public function getSoldServices($id){
		if($id == 0){
			$id = $this->user_id;
		}
		$services = PostOrder::find()->joinWith('post')->where(['post_services.owner_id'=>$id, 'type'=>'Completed'])->count();
		return $services;
	}

	/**
	 * method to get the average rating received by the user
	 * @param [int] (optional) id of the user
	 * @return [decimal] [average raing of the user]
	 */
	public function getUserRating($id=0){
		if($id == 0){
			$id = $this->user_id;
		}
		$ratings = Comments::find()->where(['user_id'=>$id])->all();
		$count = count($ratings);
		if($count > 0){
			$stars = 0;
			foreach ($ratings as $rating) {
				$stars +=  $rating->stars;
			}
			$rating = $stars / $count;
			$rating = number_format($rating, 2); 
			$rating = round($rating, 1);
			$stars = explode('.', $rating);
			$full = $stars[0];
			if(isset($stars[1])){
				$half = $stars[1];
			}else{
				$half = 0;
			}
			if($half >= 0 && $half <=3){
				$half = 0;
			}elseif($half >= 4 && $half <= 7){
				$half = 1;
			}else{
				$half = 0;
				$full += 1;
			}
			return array('full'=>$full, 'half'=>$half, 'count'=>$count);
		}else{
			return 0;
		}
	}

	/**
	 * Get the number of times the post has been sold
	 * @param  [int] $id [id of the post]
	 * @return [int]     [number of time post has been sold]
	 */
	public function getSoldCount($id){
		$count = PostOrder::find()->where(['post_id'=>$id, 'type'=>'Completed'])->count();
		return $count;
	}

	/**
	 * get the number of active orders for the post
	 * @param  [int] $id [id of the post]
	 * @return [int]     [number of active orders]
	 */
	public function getQueueCount($id){
		$count = PostOrder::find()->where('type != "Completed" AND type != "Cancelled" AND post_id = '.$id)->count();
		return $count;
	}
}