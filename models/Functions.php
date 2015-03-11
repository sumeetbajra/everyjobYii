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
	 * @return [decimal] [amount]
	 */
	public function getMoneyInAccount(){

	}

	/**
	 * get total number of active posts posted by the user
	 * @return [int] [number of active posts]
	 */
	public function getPostedServices(){
		$posted = PostServices::find()->where(['owner_id'=>$this->user_id, 'active'=>'1'])->count();
		return $posted;
	}

	/**
	 * get total number of services bought by the user
	 * @return [integer] [number of services bought by the user]
	 */
	public function getBoughtServices(){
		$sql = "SELECT t.transaction_id FROM `transaction` t JOIN `post_order` p ON t.order_id = p.order_id WHERE p.user_id = ".$this->user_id;
		$bought = Transaction::findBySql($sql)->all();
		return count($bought);
	}

	/**
	 * total number of active orders received for the service
	 * @param  [int] $id [id of the post]
	 * @return [int] [number of active orders]
	 */
	public function getOrderCount($id){
		$orderCount = PostOrder::find()->where(['type'=>'active', 'status'=>'1', 'post_id'=>$id])->count();
		return $orderCount;
	}
}