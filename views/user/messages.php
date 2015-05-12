<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Notification;
use app\models\Users;
use app\models\PostOrder;
use yii\captcha\Captcha;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\PostServices */

?>
<div class="row" style="">
<div class="col-md-3 col-sm-3 col-xs-5">
            <div class="profile-side-menu">
                <div class="profile-pic">
                    <img src="<?= Yii::getAlias('@web');?>/images/users/<?= $user->profilePic; ?>" class="img-circle img-responsive" width="100">
                    <h4 class="montserrat"><?= Html::encode($user->display_name); ?></h4>
                </div>
                <ul >
                    <li><a href="<?= Url::to(['user/dashboard'])?>"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                    <li><a href="<?= Url::to(['post/create']) ?>"><i class="fa fa-plus"></i> Create a post</a></li>
                    <li><a href="<?= Url::to(['user/activetasks']) ?>"><i class="fa fa-tasks"></i> Active tasks</a></li>
                    <li class="active"><a href="#"><i class="fa fa-envelope"></i> Messeges <span class="badge"><?= \Yii::$app->function->getMsgCount(); ?></span></a></li>
                    <li><a href="<?= Url::to(['site/notification']); ?>"><i class="fa fa-globe"></i> Notifications <span class="badge"><?= \Yii::$app->function->getNotificationCount(); ?></span></a></li>
                    <li><a href="<?= Url::to(['user/orderedservices']); ?>"><i class="fa fa-check-square-o"></i> Ordered services</a></li>
                    <li><a href="<?= Url::to(['user/transaction']); ?>"><i class="fa fa-credit-card"></i> Transaction details</a></li>
                    <li><a href="<?= Url::to(['user/profile/'.Html::encode($user->display_name)]); ?>"><i class="fa fa-user"></i> View profile</a></li>
                    <li><a href="<?= Url::to(['user/settings']); ?>"><i class="fa fa-cogs"></i> Profile Settings</a></li>
                </ul>
            </div>
        </div>
	<div class="col-md-9">
        <h3 class="montserrat">Mail</h3>Your conversations with other users<hr><br>

 <ul class="nav nav-tabs">
                <li class="active"><a href="#inbox" data-toggle="tab"><span class="glyphicon glyphicon-inbox">
                </span>Inbox [<?= \Yii::$app->function->getMsgCount(); ?>]</a></li>
                <li><a href="#sent" data-toggle="tab"><i class="fa fa-reply"></i>
                    Sent</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in active" id="inbox">
                    <div class="list-group">
                        <?php if(count($messages) == 0) : echo "<br><i>Your inbox is empty.</i><br>"; endif; ?>
                        <?php foreach ($messages as $key => $message) { 
                        if($message->read_m == '0') : ?>
                        <a href="<?= Url::to(['user/conversation/'.$message->thread_id]); ?>" class="list-group-item">
                                <?php else: ?>
                                <a href="<?= Url::to(['user/conversation/'.$message->thread_id]); ?>" class="list-group-item read">
                                 <?php endif; ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="delete[]">
                                </label>
                            </div>
                            <?php
                            if($message->read_m == '0') : ?>
                             <span class="glyphicon glyphicon-star"></span>
                         <?php else: ?>
                         <span class="glyphicon glyphicon-star-empty"></span>
                     <?php endif; ?>
                             <span class="name" style="min-width: 120px;
                                display: inline-block;"><?php if($message->read_m == '0') : ?><b><?php endif; ?><?php
                                $from = Users::findOne($message->from_user); 
                                if(empty($from)){
                                    echo "Everyjob Admin";
                                }else{
                                    echo $from->display_name;
                                }
                                ?><?php if($message->read_m == '0') : ?></b><?php endif; ?></span> <span class=""><?php if($message->read_m == '0') : ?><b><?php endif; ?><?= $message->subject; ?><?php if($message->read_m == '0') : ?></b><?php endif; ?></span>
                                  <span class="text-muted" style="font-size: 11px;">- <?= Html::encode($message->getExcerpt($message->message)); ?></span> 
                             <span
                                class="badge"><?= date('F d, Y h:i a', strtotime($message->datetimestamp)); ?></span> <span class="pull-right"><span class="glyphicon">
                                </span></span></a>
                                <?php }?>
                    </div>
                     <a href="#" class="btn btn-primary disabled msg-delete" id="inbox"><i class="fa fa-trash-o"></i> Delete selected</a>
                </div>
                <div class="tab-pane fade in" id="sent">
                          <div class="list-group">
                            <?php if(count($sent) == 0) : echo "<br><i>Your outbox is empty.</i><br>"; endif; ?>
                        <?php foreach ($sent as $key => $message) {  ?>
                        <a href="<?= Url::to(['user/conversation/'.$message->thread_id]); ?>" class="list-group-item read">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="deleteSent[]">
                                </label>
                            </div>
                             <span class="glyphicon glyphicon-star-empty"></span>
                             <span class="name" style="min-width: 120px;
                                display: inline-block;"><?= $from = Html::encode(Users::findOne($message->to_user)->display_name); ?></span> <span class=""><?= Html::encode($message->subject); ?></span>
                                  <span class="text-muted" style="font-size: 11px;">- <?= Html::encode($message->getExcerpt($message->message)); ?></span> 
                             <span
                                class="badge"><?= date('F d, Y h:i a', strtotime($message->datetimestamp)); ?></span> <span class="pull-right"><span class="glyphicon">
                                </span></span></a>
                                <?php }?>
                    </div>
                     <a href="#" class="btn btn-primary disabled msg-delete" id="outbox"><i class="fa fa-trash-o"></i> Delete selected</a>
                </div>  
</div>

</div>
