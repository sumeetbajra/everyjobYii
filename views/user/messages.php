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
                    <h4 class="montserrat"><?= $user->display_name; ?></h4>
                </div>
                <ul >
                    <li><a href="<?= Url::to(['user/dashboard'])?>"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fa fa-plus"></i> Create a post</a></li>
                    <li><a href="<?= Url::to(['user/activetasks']) ?>"><i class="fa fa-tasks"></i> Active tasks</a></li>
                    <li class="active"><a href="#"><i class="fa fa-envelope"></i> Messeges <span class="badge"><?= $msgCount; ?></span></a></li>
                    <li><a href="<?= Url::to(['site/notification']); ?>"><i class="fa fa-globe"></i> Notifications <span class="badge"><?= Notification::find()->where(['user_id'=>Yii::$app->user->getId(), 'read'=>'0'])->count();?></span></a></li>
                    <li><a><i class="fa fa-check-square-o"></i> Ordered services</a></li>
                    <li><a href="<?= Url::to(['user/profile/'.$user->display_name]); ?>"><i class="fa fa-user"></i> View profile</a></li>
                    <li><a><i class="fa fa-cogs"></i> Profile Settings</a></li>
                </ul>
            </div>
        </div>
	<div class="col-md-9">
        <h3 class="montserrat">Mail</h3><hr><br>

 <ul class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-inbox">
                </span>Inbox [<?= $msgCount; ?>]</a></li>
                <li><a href="#profile" data-toggle="tab"><span class="glyphicon glyphicon-plus"></span>
                    Conversations</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in active" id="home">
                    <div class="list-group">
                        <?php foreach ($messages as $key => $message) { 
                        if($message->read_m == '0') : ?>
                        <a href="<?= Url::to(['user/conversation/'.$message->thread_id]); ?>" class="list-group-item read">
                                <?php else: ?>
                                <a href="<?= Url::to(['user/conversation/'.$message->thread_id]); ?>" class="list-group-item">
                                 <?php endif; ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox">
                                </label>
                            </div>
                            <?php
                            if($message->read_m == '0') : ?>
                             <span class="glyphicon glyphicon-star"></span>
                         <?php else: ?>
                         <span class="glyphicon glyphicon-star"></span>
                     <?php endif; ?>
                             <span class="name" style="min-width: 120px;
                                display: inline-block;"><?= $from = Users::findOne($message->from_user)->display_name; ?></span> <span class=""><?= $message->subject; ?></span>
                                  <span class="text-muted" style="font-size: 11px;">- <?= $message->getExcerpt($message->message); ?></span> 
                             <span
                                class="badge"><?= date('F d, Y h:i a', strtotime($message->datetimestamp)); ?></span> <span class="pull-right"><span class="glyphicon">
                                </span></span></a>
                                <?php }?>
                    </div>
                </div>
                <div class="tab-pane fade in" id="profile">
                    <div class="list-group">
                        <div class="list-group-item">
                            <span>

                            </span>                           
                        </div>
                    </div>
                </div>  
</div>

</div>
