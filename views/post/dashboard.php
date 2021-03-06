<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Notification;
use app\models\Users;
use app\models\AcceptedOrders;
use app\models\PostOrder;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\grid\GridView;
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
        <li><a href="<?= Url::to(['user/activetasks']); ?>"><i class="fa fa-tasks"></i> Active tasks</a></li>
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
    <h4 class="leftborder"><i class="fa fa-th"></i> Task Dashboard</h4>
    <?php if(Yii::$app->session->getFlash('message')){ ?>
    <div class="col-md-12 alert alert-info"><?= Yii::$app->session->getFlash('message'); ?></div><br><br>
    <?php } ?>
    <?php if($order->type != 'Completed'): ?> <!--for task history purpose-->
    Here you can upload files and post the updates on the task<br><br>
     <?php 
    $accepted = AcceptedOrders::findOne($order->order_id);
    if($accepted->complete_request == 1 && $order->user_id == \Yii::$app->user->getId()){ ?>
    <div class="col-md-12 alert alert-warning">Kriti has requested you to close the task. <br><br> 
      <a href="#" data-toggle = "modal" data-target="#completeModal" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Close</a>&nbsp;
      <a href="#" class="btn btn-danger" onclick="bootbox.confirm('Are you sure?', function(message){if(message){window.location='<?=Url::to(['post/rejectcompletionrequest/'.$order->order_id]); ?>';} })"><i class="fa fa-times-circle-o"></i> Reject request</a></div>
    <?php } ?>
  <?php else: ?>
      Here you can see all the files and updates on the task. &nbsp; &nbsp;<a href="<?= Url::to(['user/taskhistory']); ?>" class="btn btn-default btn-small"><i class="fa fa-chevron-circle-left"></i> Back</a><br><br>
  <?php endif; ?><!--for task history purpose-->
    <table class="table table-bordered ">
      <tr>
        <td  colspan="2"><h4 class="montserrat" style="font-size='16px'"><?= Html::encode($order->post->title);?></h4></td>
      </tr>
      <tr>
        <td>Ordered: <?= date('Y/m/d', strtotime($order->datetimestamp));?></td>
        <?php if($order->type != 'Completed'): ?><!--for task history purpose-->
        <td>Status: In progress</td>
      <?php else: ?>
        <td>Status: Completed</td>
      <?php endif;?><!--for task history purpose-->
      </tr>
      <tr>
        <td>Delivery: <?= date('Y/m/d', strtotime($order->datetimestamp) + $order->post->max_delivery_days*86400); ?></td>
        <td>
    <?php if($order->type != 'Completed'): ?> <!--for task history purpose-->
          <?php if($order->user_id == \Yii::$app->user->getId()): ?>
          <a href="#" data-toggle = "modal" data-target="#completeModal" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Set as Completed</a>
        <?php else: ?>
        <?php if($accepted->complete_request == 1) : ?>
        <?= Html::a('<i class="fa fa-check-circle-o"></i> Requested', ['#'], ['class' => 'btn btn-success disabled']) ?>
         <?php elseif($accepted->complete_request == 3) : ?>
         <?= Html::a('<i class="fa fa-times-circle-o"></i> Request cancelled', ['#'], ['class' => 'btn btn-danger disabled']) ?>
      <?php else: ?>
      <?= Html::a('<i class="fa fa-bell-o"></i> Request buyer to close the task', ['requestcompletion', 'id' => $order->order_id], [
        'class' => 'btn btn-primary completeAjaxButton',
        'id'=> $order->order_id,
        'data' => [
        'confirm' => 'Are you sure you want to request for completion?',
        'method' => 'post',
        ],
        ]) ?><?php endif; ?>
      <?php endif; ?>
    <?php endif; ?><!--for task history purpose-->

    </td>
  </tr>
</table>
<ul class="nav nav-tabs">
  <li class="active"><a href="#status" data-toggle="tab"><span class="fa fa-comment"></span> 
    Status</a></li>
    <?php if($order->type != 'Completed'): ?> <!--for task history purpose-->
    <li><a href="#update" data-toggle="tab"><i class="fa fa-pencil-square"></i>
      Update Status</a></li>
    <?php endif; ?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane fade in active" id="status">
        <div class="list-group">
          <br>
          <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions'=>['class'=>'table action-column'],
            'columns' => [
            [
            'header'=>'User',
            'format' =>'raw',
            'value'=>function($data){ return '<a href="' . Url::to(['user/profile/'. $uname = Html::encode(Users::findOne($data->user->user_id)->display_name)]) . '">' . $uname . '</a>'; },
            ],
            [
            'header'=>'Message',
            'format' =>'raw',
            'value'=>function($data){ return Html::encode($data->status); },
            ],
            [
            'header'=>'Date/Time',
            'value'=>function($data){ return \Yii::$app->function->getAgoTime($data->datetimestamp); },
            ], 
            [
            'header'=>'Files',
            'format' =>'raw',
            'value'=>function($data){ if(!empty($data->taskFiles->file_url) ) : return '<a href= "' . \Yii::getAlias('@web/images/task/' .$data->taskFiles->file_url) . '" target="_new">' . $data->taskFiles->file_url . '</a>'; else: return 'None'; endif;},
            ],

            ],
            ]); 
            ?>

          </div>
        </div>
        <?php if($order->type != 'Completed'): ?> <!--for task history purpose-->
        <div class="tab-pane fade in" id="update">
          <div class="list-group">
           <br>
           <?php $form = ActiveForm::begin(['options'=>['id'=>'dropzone-form_1']]); ?>
           <?= Html::textArea('status', '', ['required'=>'true', 'class'=>'form-control', 'placeholder'=>'What is going on with the task?']); ?><br>
           <?php ActiveForm::end(); ?>

           <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data', 'class'=>'dropzone dropzone-forms']]); ?>
           <?= Html::fileInput('file', '', ['class'=>'hidden']); ?>
           <?php ActiveForm::end(); ?>
           <br>
           <a href="#" class="btn btn-default pull-right"><i class="fa fa-chevron-arrow-left"></i> Back</a>&nbsp; &nbsp;
           <?= Html::submitButton('<i class="fa fa-plus"></i>  Add Status', ['class' => 'btn btn-primary pull-right', 'id'=>'dropzone-btn']) ?>
           <div class="clear-fix"></div>
         </div>
       </div>
     <?php endif; ?><!--for task history purpose-->
     </div>
   </div>  
   <div class="modal fade" id="completeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Close the task</h4>
        </div>
        <div class="modal-body">
          Before closing the task, leave some feedback about the user.<br><br>
          <?php $form = ActiveForm::begin(['action'=>['post/completetask']]); ?>
          <b>Make a Comment: (Optional)</b>
          <?= Html::textArea('comment', '', ['class'=>'form-control', 'placeholder'=>'How was the experience?', 'style'=>'margin-top:10px']); ?><br>
          <b>Leave a Rating: </b> 
          <span class="glyphicon star glyphicon-star-empty" id="1"></span>
          <span class="glyphicon star glyphicon-star-empty" id="2"></span>
          <span class="glyphicon star glyphicon-star-empty" id="3"></span>
          <span class="glyphicon star glyphicon-star-empty" id="4"></span>
          <span class="glyphicon star glyphicon-star-empty" id="5"></span>
          <?= Html::hiddenInput('stars', '', ['class'=>'star-input']); ?>
          <?= Html::hiddenInput('order_id', $order->order_id); ?>
          <?= Html::hiddenInput('user_id', $order->post->owner_id); ?>
        </div>
        <div class="modal-footer">
          <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
          <?php ActiveForm::end(); ?>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
