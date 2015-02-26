<?php
use yii\helpers\Url;
use yii\grid\GridView;
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
        <li><a><i class="fa fa-globe"></i> Notifications (0)</a></li>
        <li><a><i class="fa fa-check-square-o"></i> Ordered services</a></li>
        <li><a><i class="fa fa-user"></i> View profile</a></li>
        <li><a><i class="fa fa-cogs"></i> Profile Settings</a></li>
       </ul>
    </div>
</div>
    <div class="col-md-9">
        <h3 class="montserrat"><?= $user->display_name;?></h3> (member since <?= date('F Y', strtotime($user->created_at));?>)<hr>
          <h4><b>ABOUT</b></h4>
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
                        <p>
                            <a href="#" class="btn btn-primary">Delete</a> <a href="<?= Url::to(['post/update/'.$post->post_id]);?>" class="btn btn-default">Edit</a> <a href="#" class="btn btn-default">More</a>
                        </p>
                    </div>
                </div>
            </div>
           
     <?php  } ?>
        </div>

           

    </div>
</div>