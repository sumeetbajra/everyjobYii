<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Users;
use app\models\PostServices;
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
                <li><a href="<?= Url::to(['user/inbox']);?>"><i class="fa fa-envelope"></i> Messeges <span class="badge"><?= \Yii::$app->function->getMsgCount(); ?></span></a></li>
                    <li><a href="<?= Url::to(['site/notification']); ?>"><i class="fa fa-globe"></i> Notifications <span class="badge"><?= \Yii::$app->function->getNotificationCount(); ?></span></a></li>
                <li class="active"><a href="#"><i class="fa fa-check-square-o"></i> Ordered services</a></li>
                <li><a href="<?= Url::to(['user/profile/'.$user->display_name]); ?>"><i class="fa fa-user"></i> View profile</a></li>
                <li><a><i class="fa fa-cogs"></i> Profile Settings</a></li>
            </ul>
        </div>
    </div>
   <div class="col-md-9 col-sm-9 col-xs-7">
            <h3 class="montserrat"><?= $user->display_name;?></h3> (member since <?= date('F Y', strtotime($user->created_at));?>)<hr><br>

            <ul class="nav nav-tabs">
                <li class="active"><a href="#ordered" data-toggle="tab"><span class="fa fa-paper-plane-o"></span> 
                    Ordered services</a></li>
                <li><a href="#received" data-toggle="tab"><i class="fa fa-arrow-circle-o-down"></i>
                    Received Orders</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in active" id="ordered">
                    <div class="list-group">
            <?php if(count($orders) == 0){
            echo "<i>You do not have any ordered services at the moment</i>";
        }?>                
                         <h4 class="leftborder">Ordered Services</h4>
    
        
        <?php 
        $dataProvider = new ActiveDataProvider(['query'=>$orders, 'pagination' => [
        'pageSize' => 10,
    ],]);
        ?>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
              [
            'header'=>'Service',
            'format' =>'raw',
            'value'=>function($data){ return '<a href="' . Url::to(['/post/view/' . $data->post_id . '/' . PostServices::findOne($data->post_id)->slug]) . '">' . PostServices::findOne($data->post_id)->title . '</a>'; },
            ],
             [
            'header'=>'Owner',
            'format' =>'raw',
            'value'=>function($data){ return '<a href="' . Url::to(['/user/profile/' . Users::findOne($data->post->owner_id)->display_name]) . '">' . Users::findOne($data->post->owner_id)->display_name . '</a>'; },
            ],
            'type',
            [
            'header'=>'Ordered date',
            'value'=>function($data){ return date("Y-m-d", strtotime($data->datetimestamp)); },
            ], 
             [
            'header'=>'Action',
            'format' =>'raw',
            'value'=>function($data){ return '<a href="' . Url::to(['/user/profile/' . Users::findOne($data->post->owner_id)->display_name]) . '"><i class="fa fa-info-circle"></i></a>'; },
            ],
           
        ],
    ]); ?>
                    </div>
                </div>
                <div class="tab-pane fade in" id="received">
                          <div class="list-group">
                                 <h4 class="leftborder">Received Orders</h4>
                            <?php if(count($received) == 0) : echo "<br><i>Your outbox is empty.</i><br>"; endif; ?>
                      
                        <?php 
        $dataProvider = new ActiveDataProvider(['query'=>$received, 'pagination' => [
        'pageSize' => 10,
    ],]);
        ?>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
              [
            'header'=>'Service',
            'format' =>'raw',
            'value'=>function($data){ return '<a href="' . Url::to(['/post/view/' . $data->post_id . '/' . PostServices::findOne($data->post_id)->slug]) . '">' . PostServices::findOne($data->post_id)->title . '</a>'; },
            ],
             [
            'header'=>'Ordered by',
            'format' =>'raw',
            'value'=>function($data){ return '<a href="' . Url::to(['/user/profile/' . Users::findOne($data->user_id)->display_name]) . '">' . Users::findOne($data->user_id)->display_name . '</a>'; },
            ],
            'type',
            [
            'header'=>'Ordered date',
            'value'=>function($data){ return date("Y-m-d", strtotime($data->datetimestamp)); },
            ], 
             [
            'header'=>'Action',
            'format' =>'raw',
            'value'=>function($data){ return '<a href="' . Url::to(['/user/profile/' . Users::findOne($data->post->owner_id)->display_name]) . '"><i class="fa fa-info-circle"></i></a>'; },
            ],
           
        ],
    ]); ?>
                    </div>
                </div>  

</div>
        
       
</div>



