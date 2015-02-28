<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\Notification;
?>


<?php if(!empty(Yii::$app->session->getFlash('message'))){ ?>
    <div class="col-md-12 alert alert-info"><?= Yii::$app->session->getFlash('message'); ?></div>
    <?php } ?>
    <div class="row" style="margin-top:35px">
        <div class="col-md-3">
            <div class="profile-side-menu">
                <div class="profile-pic">
                    <img src="<?= Yii::getAlias('@web');?>/images/users/<?= $user->profilePic; ?>" class="img-circle img-responsive" width="100">
                    <h4 class="montserrat"><?= $user->display_name; ?></h4>
                </div>
                <ul >
                    <li><a href="<?= Url::to(['post/create']) ?>"><i class="fa fa-plus"></i> Create a post</a></li>
                    <li><a><i class="fa fa-tasks"></i> Active tasks</a></li>
                    <li><a><i class="fa fa-envelope"></i> Messeges (0)</a></li>
                    <li><a href="<?= Url::to(['site/notification']); ?>"><i class="fa fa-globe"></i> Notifications (<?= Notification::find()->where(['user_id'=>Yii::$app->user->getId(), 'read'=>'0'])->count();?>)</a></li>
                    <li><a><i class="fa fa-check-square-o"></i> Ordered services</a></li>
                    <li><a href="<?= Url::to(['user/profile/'.$user->display_name]); ?>"><i class="fa fa-user"></i> View profile</a></li>
                    <li><a><i class="fa fa-cogs"></i> Profile Settings</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <h3 class="montserrat"><?= $user->display_name;?></h3> (member since <?= date('F Y', strtotime($user->created_at));?>)<hr>
            <h4><b>ABOUT</b> &nbsp;<a href="<?= Url::to(['user/update/'])?>" style="font-size:13px"><u>Edit</u></a></h4>
            <p><?= $user->about; ?></p>
            <p><i class="fa fa-globe"></i> <?= $user->address;?></p>
            <p><i class="fa fa-birthday-cake"></i> <?= $user->dob; ?></p>
            <hr>

            <h4><b>YOUR POSTS</b></h4>
            <div class="row text-center">

             <?php foreach ($posts as $post) { ?>
             <div class="col-md-4 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <?php if($post->featured == 1) : ?>
                    <div class="ribbon-wrapper-green"><div class="ribbon-green">Featured</div></div>
                <?php endif; ?>
                <img src="<?= Yii::getAlias('@web'); ?>/images/services/<?= $post->image_url; ?>" alt="Promotional image">
                <div class="caption">
                    <h4>Price: <?= $post->currency, ' ', $post->price; ?></h4>
                    <p><?= $post->title; ?></p>                           
                    <?php $form = ActiveForm::begin([
                        'method'=>'POST',
                        'action' => ['post/update'],
                        ]);
                        ?>
                        <input type="hidden" name="post_id" value="<?= $post->post_id; ?>">
                        <a href="#" class="btn btn-primary">Delete</a> 
                        <button class="btn btn-default" type="submit">Edit</button>
                        <a href="#" class="btn btn-default">More</a>
                        <?php ActiveForm::end() ?>                        
                    </div>
                </div>
            </div>

            <?php  } ?>
        </div>



    </div>
</div>

