<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Notification;
use app\models\Users;
use app\models\Message;
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
                <li><a href="#"><i class="fa fa-plus"></i> Create a post</a></li>
                <li><a href="<?= Url::to(['user/activetasks']) ?>"><i class="fa fa-tasks"></i> Active tasks</a></li>
                <li><a href="<?= Url::to(['user/inbox']);?>"><i class="fa fa-envelope"></i> Messeges <span class="badge"><?= \Yii::$app->function->getMsgCount(); ?></span></a></li>
                    <li><a href="<?= Url::to(['site/notification']); ?>"><i class="fa fa-globe"></i> Notifications <span class="badge"><?= \Yii::$app->function->getNotificationCount(); ?></span></a></li>
                <li><a href="<?= Url::to(['user/orderedservices']); ?>"><i class="fa fa-check-square-o"></i> Ordered services</a></li>
                <li><a href="<?= Url::to(['user/profile/'.Html::encode($user->display_name)]); ?>"><i class="fa fa-user"></i> View profile</a></li>
                <li><a><i class="fa fa-cogs"></i> Profile Settings</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <h3 class="montserrat">Mail</h3>
        <?php 
        if($messages[0]->from_user == Yii::$app->user->getId()){
           $to = Users::findOne($messages[0]->to_user);      
       }else{
        $to = Users::findOne($messages[0]->from_user);      
    }
    ?>
    
    Your conversation with <?php 
    if(empty($to)){
        echo 'Everyjob Admin';
    }else{
        echo Html::encode($to->display_name);
    }
    ?> on <?= Html::encode($messages[0]->subject);?><hr><br>

    <?php if (!empty($to)) : ?>
    <a class="btn btn-primary" href="#" data-target = "#reply-convo" data-toggle="modal"><i class="fa fa-reply"></i> Reply</a>
<?php endif; ?>
    <a class="btn btn-default" href="<?= Url::to(['user/inbox']); ?>"><i class="fa fa-chevron-circle-left"></i> Back to Inbox</a>
    <br><br>
    <div class="mgs-visible">
        <?php foreach($messages as $message){ 
            $to_user = ((Users::findOne($message->from_user)) ? Users::findOne($message->from_user) : '');
            ?>
            <div class="msg-thread-one">
                <?php $profilePic = ((empty($to_user)) ? 'default.jpg' : $to_user->profilePic);
                $display_name = ((empty($to_user)) ? 'Everyjob Admin' : $to_user->display_name);
                ?>
                <img src="<?= Yii::getAlias('@web/images/users/'.$profilePic) ?>" class="img-thumbnail pull-left" width="60"><span class="montserrat" style=" margin-left: 10px"><?= $display_name; ?> </span><br><span style="margin-left: 10px; font-size: 12px"><?= date('F d, Y H:i a', strtotime($message->datetimestamp)); ?></span><br>
                <div class="clear-fix"></div>
                <br>
                <div class="msg-thread-msg"><div class="arrow-up"></div><p><?= Html::encode($message->message); ?></p></div>
            </div>
            <?php } ?>
        </div>
        <br> 
    </div>
</div>
</div>

<?php if (!empty($to)) : ?>
<div class="modal fade" id="reply-convo" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Type your message</h4>
            </div>
            <div class="modal-body">
               <?php 
               $model = new Message;
               $form = ActiveForm::begin(['action'=>['user/sendmessage/'. Html::encode($to->display_name)]]);?>
               <?= Html::activeHiddenInput($model, 'subject', ['value'=>Html::encode($messages[0]->subject)]); ?>
               <?= $form->field($model, 'message')->textarea(['placeholder'=>'Type your message', 'rows'=>'5']);?>
               <?= Html::activeHiddenInput($model, 'to_user', ['value'=>$to->user_id]); ?>
               <?= Html::activeHiddenInput($model, 'thread_id', ['value'=>$messages[0]->thread_id]); ?>
               <?= $form->field($model, 'captcha')->widget(Captcha::className()); ?>
           </div>
           <div class="modal-footer">
             <?= Html::submitButton('Send', ['class' => 'btn pull-right', 'name' => 'message-button']) ?>
         </div>
     </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>