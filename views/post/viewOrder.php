<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Users;
use app\models\RejectedOrder;

/* @var $this yii\web\View */
/* @var $model app\models\PostServices */
/* @var $form yii\widgets\ActiveForm */
$user = Users::findOne(\Yii::$app->user->getId());
?>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-5">
            <div class="profile-side-menu">
                <div class="profile-pic">
                    <img src="<?= Yii::getAlias('@web');?>/images/users/<?= Html::encode($user->profilePic); ?>" class="img-circle img-responsive" width="100">
                    <h4 class="montserrat"><?= Html::encode($user->display_name); ?></h4>
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
        <div class="col-md-9 col-sm-9 col-xs-7">

  <?php if(Yii::$app->session->getFlash('message')){ ?>
    <div class="col-md-12 alert alert-info"><?= Yii::$app->session->getFlash('message'); ?></div>
    <?php } ?>

        <h3 class="montserrat">Received Orders</h3>
<?= Html::encode($model->title); ?>
<hr><br>
 <?php if($number == 0) :?>
        <i>You have no pending orders</i>
        <?php else: ?>
        <!-- You have received new order(s) -->
        <?php endif; ?>
<?php foreach($orders as $order){
    $reject = new RejectedOrder;
    ?>
    <div class="post-order">

        <div class="row">
            <div class="col-sm-1"><img src ="<?= Yii::getAlias('@web/images/users/'.Html::encode(Users::find()->where(['user_id'=>$order->user_id])->one()->profilePic)); ?>" class="img-responsive"></div>
            <div class="col-sm-11" style="padding-left: 0px"><span class="montserrat" style="font-size: 12px"><a href="<?= Url::to(['user/profile/'.Users::findOne($order->user_id)->display_name]); ?>"><?= Html::encode(Users::findOne($order->user_id)->display_name); ?></a></span> &bull; <font size="1" color="#AAA1A1"><?= date('F d Y', strtotime($order->datetimestamp)); ?></font>
                  <?php $form = ActiveForm::begin(['action'=>['post/acceptorder'], 'options'=>['style'=>'float:right']]); ?>
    <?= Html::hiddenInput('order_id', $order->order_id);?>
    <button type="submit" href="#" class="btn btn-primary btn-success" id="confirmOrder"><i class="fa fa-check"></i> Accept</button> 
    <a href="" class="btn btn-primary btn-danger reject-order-btn"><i class="fa fa-times"></i> Reject</a>
        <?php ActiveForm::end(); ?>

            
            <p style="margin-top: 4px"><?= Html::encode($order->details); ?></p>
        </div>
    </div>
<hr>

<div class="reject-form hidden-form">
    <h4 class="montserrat">Let them know why their order got rejected</h4>
<?php $form = ActiveForm::begin(['action'=>Url::to(['post/processorder'])]); ?>
    <?= $form->field($reject, 'reason')->textarea(['rows' => 6, 'placeholder'=>'Make it concise and clear', 'required'=>'true']) ?>
    <?= Html::activeHiddenInput($reject, 'order_id', ['value'=>$order->order_id]); ?>
    <?= Html::hiddenInput('post_id', $order->post_id); ?>
    <?= Html::hiddenInput('user_id', $order->user_id); ?>
    <?= Html::submitButton('Submit',  ['class' =>'btn btn-primary pull-right']) ?>
</div> 

</div>
<?php ActiveForm::end(); ?>
<?php } ?>


</div>
  </div>


<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Are you sure?</h4>
            </div>
            <div class="modal-body">
               You won't be able to revert this action.
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" data-dismiss="modal">Confirm</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

