<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\Notification;
use app\models\WithdrawTransaction;
?>

<div class="row">
    <div class="col-md-3 col-sm-3 col-xs-5">
        <div class="profile-side-menu">
            <div class="profile-pic">
                <img src="<?= Yii::getAlias('@web');?>/images/users/<?= $user->profilePic; ?>" class="img-circle img-responsive" width="100">
                <h4 class="montserrat"><?= Html::encode($user->display_name); ?></h4>
            </div>
            <ul>
                  <li><a href="<?= Url::to(['user/dashboard'])?>"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                <li><a href="<?= Url::to(['post/create']) ?>"><i class="fa fa-plus"></i> Create a post</a></li>
                <li><a href="<?= Url::to(['user/activetasks']) ?>"><i class="fa fa-tasks"></i> Active tasks</a></li>
                <li><a href="<?= Url::to(['user/inbox']);?>"><i class="fa fa-envelope"></i> Messeges <span class="badge"><?= \Yii::$app->function->getMsgCount(); ?></span></a></li>
                <li><a href="<?= Url::to(['site/notification']); ?>"><i class="fa fa-globe"></i> Notifications <span class="badge"><?= \Yii::$app->function->getNotificationCount(); ?></span></a></li>
                <li><a href="<?= Url::to(['user/orderedservices']); ?>"><i class="fa fa-check-square-o"></i> Ordered services</a></li>
                <li class="active"><a href="#"><i class="fa fa-credit-card"></i> Transaction details</a></li>
                <li><a href="<?= Url::to(['user/profile/'.Html::encode($user->display_name)]); ?>"><i class="fa fa-user"></i> View profile</a></li>
                <li><a><i class="fa fa-cogs"></i> Profile Settings</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-9 col-sm-9 col-xs-7">
        <?php if(Yii::$app->session->getFlash('message')){ ?>
        <div class="col-md-12 alert alert-info"><?= Yii::$app->session->getFlash('message'); ?></div>
        <?php } ?>
        <h3 class="montserrat"><?= Html::encode($user->display_name);?></h3> (member since <?= date('F Y', strtotime($user->created_at));?>)<hr>
     <h4 class="leftborder"><i class="fa fa-credit-card"></i> Transaction Information</a></h4>

     <ul class="nav nav-tabs">
  <li class="active"><a href="#out" data-toggle="tab"><span class="fa fa-sign-out"></span> 
    Payment made</a></li>
    <li><a href="#in" data-toggle="tab"><i class="fa fa-sign-in"></i>
      Payment received</a></li>
    </ul>
    <!-- Tab panes -->
      <div class="tab-content">
      <div class="tab-pane fade in active" id="out">
        <div class="list-group">
            <br>
     <table class="myTable table-striped display">
         <thead>
            <tr>
                <th>Transaction_Id</th>
                <th>Post</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
 
        <tfoot>
                <tr>
                <th>Transaction_Id</th>
                <th>Post</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </tfoot>
 
        <tbody>
            <?php foreach ($transactionsOut as $key => $transaction) { ?>
            <tr>
                <td>
                    <?= $transaction->transaction_id ?>
                </td>
                <td>
                    <?= Html::encode($transaction->post->title); ?>
                </td>
                <td>
                    <?= date('M d, Y', strtotime($transaction->datetimestamp)); ?>
                </td>
                <td>
                    <?= "Rs. " . $transaction->post_price; ?>
                </td>
                <td>
                    <?= $transaction->payment_status; ?>
                </td>
            </tr>
                
            <?php } ?>
        </tbody>
     </table>
 </div>
</div>
      <div class="tab-pane fade in" id="in">
        <div class="list-group">
            <br>
             <table class="myTable table-striped display">
         <thead>
            <tr>
                <th>Transaction_Id</th>
                <th>Post</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
 
        <tfoot>
                <tr>
                <th>Transaction_Id</th>
                <th>Post</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </tfoot>
 
        <tbody>
            <?php foreach ($transactionsIn as $key => $transaction) {?>
            <tr>
                <td>
                    <?= Html::encode($transaction->transaction_id); ?>
                </td>
                <td>
                    <?= Html::encode($transaction->post->title); ?>
                </td>
                <td>
                    <?= date('M d, Y', strtotime($transaction->datetimestamp)); ?>
                </td>
                <td>
                    <?= "Rs. " . $transaction->post_price; ?>
                </td>
                <td>
                    <?= $transaction->payment_status; ?>
                </td>
                <td>
                    <?php 
                    if(empty($transaction->withdraw)){ ?>
                        <a href="<?= Url::to(['user/withdraw/?stamp='.HTML::encode($transaction->transaction_id)]); ?>" class="btn btn-primary btn-sm">Withdraw</a>
                    <?php }elseif ($transaction->withdraw->datetimestamp == '') { ?>
                        <a href="#" class="btn btn-primary btn-sm disabled">Requested</a>
                    <?php }else{ ?>
                        <a href="#" class="btn btn-success btn-sm disabled">Received</a>
                    <?php } ?>                    
                </td>
            </tr>
                
            <?php } ?>
        </tbody>
     </table>
        </div>
    </div>
</div>
</div>
</div>

