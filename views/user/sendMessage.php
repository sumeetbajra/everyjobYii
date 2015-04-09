<?php  
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Notification;
use app\models\Users;
use app\models\PostOrder;
use yii\captcha\Captcha;
 
 ?>

 <div class="row" style="">
<div class="col-md-3 col-sm-3 col-xs-5">
            <div class="profile-side-menu">
                <div class="profile-pic">
                    <img src="<?= Yii::getAlias('@web');?>/images/users/<?= $user->profilePic; ?>" class="img-circle img-responsive" width="100">
                    <h4 class="montserrat"><?= $user->display_name; ?></h4>
                </div>
                <ul >
                    <li><a href="<?= Url::to(['user/dashboard'])?>"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                    <li><a href="<?= Url::to(['post/create']) ?>"><i class="fa fa-plus"></i> Create a post</a></li>
                    <li><a href="<?= Url::to(['user/activetasks']) ?>"><i class="fa fa-tasks"></i> Active tasks</a></li>
                    <li><a href="<?= Url::to(['user/inbox']);?>"><i class="fa fa-envelope"></i> Messeges <span class="badge"><?= \Yii::$app->function->getMsgCount(); ?></span></a></li>
                    <li><a href="<?= Url::to(['site/notification']); ?>"><i class="fa fa-globe"></i> Notifications <span class="badge"><?= \Yii::$app->function->getNotificationCount(); ?></span></a></li>
                    <li><a href="<?= Url::to(['user/orderedservices']); ?>"><i class="fa fa-check-square-o"></i> Ordered services</a></li>
                    <li><a href="<?= Url::to(['user/transaction']); ?>"><i class="fa fa-credit-card"></i> Transaction details</a></li>
                    <li><a href="<?= Url::to(['user/profile/'.Html::encode($user->display_name)]); ?>"><i class="fa fa-user"></i> View profile</a></li>
                    <li><a href="<?= Url::to(['user/settings']); ?>"><i class="fa fa-cogs"></i> Profile Settings</a></li>
                </ul>
            </div>
        </div>
	<div class="col-md-9">
   <h3 class="montserrat">Send new message to <?= Html::encode($to->display_name);?></h3>
    <hr>

    <?php $form = ActiveForm::begin(['action'=>['user/sendmessage/'. Html::encode($to->display_name)]]);?>
                    <?= $form->field($model, 'subject')->textInput(['placeholder'=>'Subject']);?>
                    <?= $form->field($model, 'message')->textarea(['placeholder'=>'Type your message', 'rows'=>'5']);?>
                    <?= Html::activeHiddenInput($model, 'to_user', ['value'=>$to->user_id]); ?>
                    <?= $form->field($model, 'captcha')->widget(Captcha::className()); ?>
           <?= Html::submitButton('Send', ['class' => 'btn pull-right', 'name' => 'message-button']) ?>
       </div>