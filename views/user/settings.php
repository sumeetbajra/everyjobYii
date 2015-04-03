<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\Notification;
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
                <li><a href="<?= Url::to(['user/transaction']); ?>"><i class="fa fa-credit-card"></i> Transaction details</a></li>
                <li><a href="<?= Url::to(['user/profile/'.Html::encode($user->display_name)]); ?>"><i class="fa fa-user"></i> View profile</a></li>
                <li  class="active"><a href="#"><i class="fa fa-cogs"></i> Profile Settings</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-9 col-sm-9 col-xs-7">
        <?php if(Yii::$app->session->getFlash('message')){ ?>
        <div class="col-md-12 alert alert-info"><?= Yii::$app->session->getFlash('message'); ?></div>
        <?php } ?>
        <h3 class="montserrat"><?= Html::encode($user->display_name);?></h3> (member since <?= date('F Y', strtotime($user->created_at));?>)<hr>
        <h4 class="leftborder"><i class="fa fa-cog"></i> Profile Settings</h4>
            <table class="table table-responsive profile-settings">
            <tr>
                <td style="width: 300px">
                    First Name:
                </td>
                <td>
                <?= $user->fname; ?> &nbsp;<a href="<?= Url::to(['user/update']);?>#fname" class="settings-edit"><i class="fa fa-pencil"></i></a>
                </td>
            </tr>
            <tr>
                <td>
                    Last Name:
                </td>
                <td>
                <?= $user->lname; ?> &nbsp;<a href="<?= Url::to(['user/update']);?>#fname" class="settings-edit"><i class="fa fa-pencil"></i></a>
                </td>
                </tr>
            <tr>
                <td>
                    Date of Birth:
                </td>
                <td>
                <?= $user->dob; ?> &nbsp;<a href="<?= Url::to(['user/update']);?>#dob" class="settings-edit"><i class="fa fa-pencil"></i></a>
                </td>
                </tr>
            <tr>
                <td>
                    Display name:
                </td>
                <td>
                <?= $user->display_name; ?> &nbsp;<a href="<?= Url::to(['user/update']);?>#display_name" class="settings-edit"><i class="fa fa-pencil"></i></a>
                </td>
                </tr>
            <tr>
                <td>
                    Email:
                </td>
                <td>
                <?= $user->email; ?> &nbsp;<a href="<?= Url::to(['user/update']);?>#display_name" class="settings-edit"><i class="fa fa-pencil"></i></a>
                </td>
                </tr>
                <tr>
                <td>
                    Location:
                </td>
                <td>
                <?= $user->address; ?> &nbsp;<a href="<?= Url::to(['user/update']);?>#location" class="settings-edit"><i class="fa fa-pencil"></i></a>
                </td>
                </tr>
            <tr>
                <td>
                    Password:
                </td>
                <td>
                ********** &nbsp;<a href="#" class="settings-edit"><i class="fa fa-pencil"></i></a>
                </td>
                </tr>
            <tr>
                <td>
                    Profile Picture:
                </td>
                <td>
                <img src="<?= \Yii::getAlias('@web/images/users/'.$user->profilePic); ?>" height="200" > &nbsp;<a href="<?= Url::to(['user/update']);?>#profilePic" class="settings-edit"><i class="fa fa-pencil"></i></a>
                </td>
            </tr>
            </table>        
</div>
</div>

