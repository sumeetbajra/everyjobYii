<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Notification;
use app\models\Transaction;
use app\models\Users;
use app\models\PostOrder;
use yii\captcha\Captcha;
use yii\helpers\Html;
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
            <h3 class="montserrat"><?= Html::encode($user->display_name);?></h3> (member since <?= date('F Y', strtotime($user->created_at));?>)<hr>
            <h4 class="leftborder"><i class="fa fa-history"></i> Task History</h4>
            <a href="<?= Url::to(['user/activetasks']); ?>" class="btn btn-default btn-small"><i class="fa fa-chevron-circle-left"></i> Back</a><br>
            <br>
            <table class="myTable table-striped display">
                <thead>
                    <tr>
                        <td>
                            Order Id
                        </td>
                        <td>
                            Service Name
                        </td>
                        <td>
                            Owner
                        </td>
                        <td>
                            Ordered by
                        </td>
                        <td>
                            Order accepted
                        </td>
                        <td>
                            Closed date
                        </td>
                        <td>
                            Actions
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($tasks as $task): ?>
                        <tr>
                            <td>
                                <?= $task->order_id; ?>
                            </td>
                            <td>
                                <?= $task->posts->title; ?>
                            </td>
                            <td>
                                <a href="<?= Url::to(['user/profile/'. Users::findOne($task->posts->owner_id)->display_name]); ?>"><?= Users::findOne($task->posts->owner_id)->display_name; ?></a>
                            </td>
                            <td>
                                <a href="<?= Url::to(['user/profile/'. Users::findOne($task->user_id)->display_name]); ?>"><?= Users::findOne($task->user_id)->display_name; ?></a>
                            </td>
                            <td>
                                <?= date('M d, Y', strtotime($task->datetimestamp)); ?>
                            </td>
                            <td>
                                <?= date('M d, Y', strtotime($task->closed_date)); ?>
                            </td>
                            <td>
                            <a class="btn btn-primary btn-sm" href="<?= Url::to(['post/taskdashboard/'.$task->order_id]); ?>">Dashboard</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>

                 <tfoot>
                    <tr>
                        <td>
                            Order Id
                        </td>
                        <td>
                            Service Name
                        </td>
                        <td>
                            Owner
                        </td>
                        <td>
                            Ordered by
                        </td>
                        <td>
                            Order accepted
                        </td>
                        <td>
                            Delivered date
                        </td>
                        <td>
                            Actions
                        </td>
                    </tr>
                </tfoot>
            </table>


    </div>
</div>


