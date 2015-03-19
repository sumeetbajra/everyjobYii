<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Notification;
use app\models\Users;
use app\models\PostOrder;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\grid\GridView;
?>


<?php if(Yii::$app->session->getFlash('message')){ ?>
    <div class="col-md-12 alert alert-info"><?= Yii::$app->session->getFlash('message'); ?></div>
    <?php } ?>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-5">
            <div class="profile-side-menu">
                <div class="profile-pic">
                    <img src="<?= Yii::getAlias('@web');?>/images/users/<?= $user->profilePic; ?>" class="img-circle img-responsive" width="100">
                    <h4 class="montserrat"><?= $user->display_name; ?></h4>
                </div>
                <ul >
                    <li><a href="<?= Url::to(['user/dashboard'])?>"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                    <li><a href="<?= Url::to(['post/create']) ?>"><i class="fa fa-plus"></i> Create a post</a></li>
                    <li class="active"><a><i class="fa fa-tasks"></i> Active tasks</a></li>
                    <li><a href="<?= Url::to(['user/inbox']);?>"><i class="fa fa-envelope"></i> Messeges <span class="badge"><?= \Yii::$app->function->getMsgCount(); ?></span></a></li>
                    <li><a href="<?= Url::to(['site/notification']); ?>"><i class="fa fa-globe"></i> Notifications <span class="badge"><?= \Yii::$app->function->getNotificationCount(); ?></span></a></li>
                    <li><a href="<?= Url::to(['user/orderedservices']); ?>"><i class="fa fa-check-square-o"></i> Ordered services</a></li>
                    <li><a href="<?= Url::to(['user/profile/'.$user->display_name]); ?>"><i class="fa fa-user"></i> View profile</a></li>
                    <li><a><i class="fa fa-cogs"></i> Profile Settings</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9 col-sm-9 col-xs-7">
            <h3 class="montserrat"><?= $user->display_name;?></h3> (member since <?= date('F Y', strtotime($user->created_at));?>)<hr>
            <h4 class="leftborder"><i class="fa fa-th"></i> Task Dashboard</h4>
            Here you can upload files and post the updates on the task<br><br>
            <table class="table table-bordered table-condensed">
                <tr>
                    <td  colspan="2"><h4 class="montserrat"><?= $order->post->title;?></h4></td>
                </tr>
                <tr>
                    <td>Ordered: <?= date('Y/m/d', strtotime($order->datetimestamp));?></td>
                    <td>Status: In progress</td>
                </tr>
                <tr>
                    <td>Delivery: <?= date('Y/m/d', strtotime($order->datetimestamp) + $order->post->max_delivery_days*86400); ?></td>
                    <td><a href="#" class="btn btn-success"><i class="fa fa-check"></i> Set as completed</a></td>
                </tr>
            </table>

            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-bordered action-column'],
        'columns' => [
              [
            'header'=>'Posted by',
            'format' =>'raw',
            'value'=>function($data){ return '<a href="' . Url::to(['user/profile/'.Users::findOne($data->user->user_id)->display_name]) . '">' . Users::findOne($data->user->user_id)->display_name . '</a>'; },
            ],
             [
            'header'=>'Message',
            'format' =>'raw',
            'value'=>function($data){ return $data->status; },
            ],
            [
            'header'=>'Date/Time',
            'value'=>function($data){ return date("Y-m-d H:i", strtotime($data->datetimestamp)); },
            ], 
             [
            'header'=>'File',
            'format' =>'raw',
            'value'=>function($data){ if(!empty($data->taskFiles->file_url) ) : return $data->taskFiles->file_url; else: return 'No file attached'; endif;},
            ],
           
        ],
    ]); 
    ?>
<a href="#" class="btn btn-default pull-right"><i class="fa fa-chevron-arrow-left"></i> Back</a>&nbsp; &nbsp;
    <a href="#" class="btn btn-primary  pull-right"><i class="fa fa-plus"></i> Add status</a>
        </div>
    </div>


