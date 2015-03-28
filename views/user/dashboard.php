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
                <li class="active"><a href="#"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                <li><a href="<?= Url::to(['post/create']) ?>"><i class="fa fa-plus"></i> Create a post</a></li>
                <li><a href="<?= Url::to(['user/activetasks']) ?>"><i class="fa fa-tasks"></i> Active tasks</a></li>
                <li><a href="<?= Url::to(['user/inbox']);?>"><i class="fa fa-envelope"></i> Messeges <span class="badge"><?= \Yii::$app->function->getMsgCount(); ?></span></a></li>
                <li><a href="<?= Url::to(['site/notification']); ?>"><i class="fa fa-globe"></i> Notifications <span class="badge"><?= \Yii::$app->function->getNotificationCount(); ?></span></a></li>
                <li><a href="<?= Url::to(['user/orderedservices']); ?>"><i class="fa fa-check-square-o"></i> Ordered services</a></li>
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
        <h4 class="leftborder"><i class="fa fa-bar-chart"></i> Account Information</a></h4>
        <div class="row text-center">
            <div class="col-md-12">

                <div class="classWithPadding  col-md-3 col-sm-6">

                  <div class="panel panel-default" style="padding:0">
                      <div class="panel-body">
                        <h2>Rs. <?= \Yii::$app->function->getMoneySpent(); ?></h2>
                    </div>
                    <div class="panel-footer">Money spent</div>
                </div>
            </div>

            <div class="classWithPadding col-md-3 col-sm-6">

                <div class="panel panel-default " style="padding:0">
                  <div class="panel-body">
                    <h2><?= \Yii::$app->function->getPostedServices(); ?></h2>
                </div>
                <div class="panel-footer">Services posted</div>
            </div>
        </div>

        <div class="classWithPadding col-md-3 col-sm-6">

            <div class="panel panel-default " style="padding:0">
              <div class="panel-body">
                <h2><?= \Yii::$app->function->getBoughtServices(); ?></h2>
            </div>
            <div class="panel-footer">Services bought</div>
        </div>
    </div>

    <div class="classWithPadding col-md-3 col-sm-6">
        <div class="panel panel-default " style="padding:0">

          <div class="panel-body">
            <?php 
            $rate = \Yii::$app->function->getCurrencyRate();
            ?>
            <h2>Rs. <?= (\Yii::$app->function->getMoneyForWithdraw())/("$rate");?></h2>
        </div>
        <div class="panel-footer">Money ready for withdraw</div>
    </div>
</div>
</div>


</div><div class="clear-fix"></div>
<h4 class="leftborder"><i class="fa fa-info-circle"></i> About &nbsp;<a href="<?= Url::to(['user/update/'])?>" style="font-size:13px; color:black"><i class="fa fa-pencil"></i></a></h4>
<p><?= Html::encode($user->about); ?></p>
<p><i class="fa fa-globe"></i> <?= Html::encode($user->address);?></p>
<p><i class="fa fa-birthday-cake"></i> <?= $user->dob; ?></p><div class="clear-fix"></div>
<h4 class="leftborder"><i class="fa fa-file-archive-o"></i> Your posts</h4>
<?php if(count($posts) == 0): echo "<i>You have not posted any services yet. Go ahead and <a href='" . Url::to(['post/create']) . "'>create</a> one now</i>"; endif;?>
    <div class="row text-center">
       <?php foreach ($posts as $post) { ?>
       <div class="col-md-4  hero-feature">
        <div class="thumbnail">
            <?php if($post->featured == 1) : ?>
            <div class="ribbon-wrapper-green"><div class="ribbon-green">Featured</div></div>
        <?php endif; ?>
        <img src="<?= Yii::getAlias('@web'); ?>/images/services/<?= $post->image_url; ?>" alt="Promotional image">
        <div class="caption">
            <h4>Price: <?= $post->currency, ' ', Html::encode($post->price); ?></h4>
            <p><?= Html::encode($post->title); ?></p>                           
            <?php $form = ActiveForm::begin([
                'method'=>'POST',
                'action' => ['post/update'],
                ]);
                ?>
                <input type="hidden" name="post_id" value="<?= $post->post_id; ?>">
                <a href="#" class="btn btn-primary">Delete</a> 
                <button class="btn btn-default" type="submit">Edit</button>
                <a href="<?= Url::to(['post/vieworder/'.$post->post_id]); ?>" class="btn btn-default">Orders (<?= \Yii::$app->function->getOrderCount($post->post_id); ?>)</a>
                <?php ActiveForm::end() ?>                        
            </div>
        </div>
    </div>

    <?php  } ?>
</div>



</div>
</div>

