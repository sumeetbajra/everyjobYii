<?php

namespace app\models;

class Functions{
	public $user_id;

	public function __construct(){
		$this->user_id = \Yii::$app->user->getId();
	}

	public function getNotificationCount(){
		$notificCount = Notification::find()->where(['user_id'=>$this->user_id, 'read'=>'0'])->count();
		return $notificCount;
	}

	public function getMsgCount(){
		$msgCount = Message::find()->where(['to_user'=>$this->user_id, 'read_m'=>'0'])->count();
		return $msgCount;
	}
}