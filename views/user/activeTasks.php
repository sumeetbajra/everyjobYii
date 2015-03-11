<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Notification;
use app\models\Users;
use app\models\PostOrder;
use yii\captcha\Captcha;
use yii\helpers\Html;
?>


<?php if(!empty(Yii::$app->session->getFlash('message'))){ ?>
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
            <h4 class="leftborder"><i class="fa fa-tasks"></i> Active tasks</h4>
      <div id="accordion">
        <?php if(count($tasks) == 0){
            echo "<i>You have no active tasks at the moment</i>";
        }?>
    <?php foreach ($tasks as $key => $task) { ?>
  <section id="item<?= $key+1; ?>" class="<?php if($key == '1'): echo 'ac_hidden'; endif;  ?>">
    <p class="pointer">&#9654;</p><h1><a href="#"><?= $task->posts->title; ?></a></h1>
    <a class = 'btn btn-default pull-right' href = '<?= Url::to(['post/taskdashboard/'.$task->order_id]); ?>' id="task-dashboard-btn"><i class="fa fa-th" title="Task Dashboard"></i> Task Dashboard</a>
    <table class="table">
        <tr>
            <td>
                Delivery date:
            </td>
            <td>
                <?= date('Y-m-d', time() + $task->posts->max_delivery_days*86400); ?>
            </td>
        </tr>

          <tr>
            <td>
                Delivery to:
            </td>
            <td>
                <a href="<?= Url::to(['user/profile/'.Users::findOne($task->user_id)->display_name]); ?>"><?= Users::findOne($task->user_id)->display_name;?></a>
            </td>
        </tr>

          <tr>
            <td>
                Additional info:
            </td>
            <td>
                <?= PostOrder::findOne($task->order_id)->details; ?>
            </td>
        </tr>
    </table>
  </section>
<?php } ?>
</div>

         

    </div>
</div>


