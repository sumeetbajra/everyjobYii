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

        <h3 class="montserrat">Order Status #<?= $order->order_id; ?></h3><hr><br>

        <table class="table table-bordered table-responsive">
            <tr>
                <td>
                Order Id:
                </td>
                <td>
                <?= $order->order_id; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Post title
                </td>
                <td>
                    <?= Html::encode($order->post->title); ?>                
                </td>
            </tr>
             <tr>
                <td>
                    Price
                </td>
                <td>
                    Rs. <?= $order->post->price; ?>                
                </td>
            </tr>
            <tr>
            <td>
                    Owner
                </td>
                <td>
                    <a href="<?= Url::to(['user/profile/'.Users::findOne($order->post->owner_id)->display_name]); ?>"><?= Users::findOne($order->post->owner_id)->display_name; ?></a>
                </td>
            </tr>
            <tr>
                <td>
                    Ordered by
                </td>
                <td>
                    <a href="<?= Url::to(['user/profile/'.Users::findOne($order->user_id)->display_name]); ?>"><?= Users::findOne($order->user_id)->display_name; ?></a>
                </td>
            </tr>
            <tr>
                <td>
                    Ordered date:
                </td>
                <td>
                    <?= date('M d, Y', strtotime($order->datetimestamp)); ?>
                </td>
            </tr>
             <tr>
                <td>
                    Additional details:
                </td>
                <td>
                    <?= Html::encode($order->details); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Status:
                </td>
                <td>
                    <?= Html::encode($order->type); ?>
                </td>
            </tr>
        </table>


 <?php if($order->user_id == \Yii::$app->user->getId() && strtolower($order->type) == 'awaiting approval'): ?>
    <a class="btn btn-danger" onclick="bootbox.confirm('Are you sure?', function(result){if(result){window.location='<?= Url::to(['post/cancelorder/'.$order->order_id]);?>'}})"><i class="fa fa-times-circle"></i> Cancel Order</a>
 <?php endif; ?>
<a class="btn btn-default" href="<?= Url::to(['user/orderedservices']); ?>"><i class="fa fa-chevron-circle-left"></i> Back</a>


</div>
  </div>


