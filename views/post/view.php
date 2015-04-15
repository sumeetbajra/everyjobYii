<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\PostViews;
use app\models\PostOrder;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PostServices */

?>
 <!-- Page Content -->
    <div class="container">
        <div class="row">

            <div class="col-md-8">

                <div class="thumbnail">
                    <h3 class="service-title"><?= Html::encode($model->title); ?></h3>
                    <hr>
                    <span>by <a target="_blank" href="http://bootsnipp.com"><?= Html::encode($model->owner->display_name); ?></a></span>&nbsp;&nbsp;
                    <span><i class="fa fa-calendar"></i> <?=  date('F d Y', strtotime($model->datetimestamp)); ?></span>&nbsp;&nbsp;
                    <span>Category: <a href="#"><?= $model->category->category_name; ?></a></span><br><br>
                    <img class="img-responsive img-thumbnail" src="<?= Yii::getAlias('@web/images/services/'.$model->image_url)?>" alt="Promotional image for the service post">
                    <div class="caption-full">
                        <h3>Service Description</h3><hr>
                        <p><?= $model->description; ?></p>
                    </div>
                    <div class="clear-fix"></div>
                    
                </div>

                <div class="well">
                  <h4>User Reviews</h4>
                    <hr>
                    <?php if(count($comments) > 0): ?>
                    <?php foreach($comments as $comment){ ?>
                    <div class="row">
                        <div class="col-md-12">
                               <img src="<?= \Yii::getAlias('@web/images/users/'.$comment->commentBy->profilePic); ?>" class="img-circle pull-left" style="margin-right:15px"width="80"><a href="<?= Url::to(['user/profile/'.$comment->commentBy->display_name]);?>" style="display:block; margin-bottom: -15px"><?= $comment->commentBy->display_name; ?></a><br>
                           <?php for($i = 1; $i <= $comment->stars; $i++){ ?>
                                       <span class="glyphicon glyphicon-star"></span>
                                       <?php } ?> 
                                       <?php for($i = 1; $i <= 5 - $comment->stars; $i++){ ?>
                                       <span class="glyphicon glyphicon-star-empty"></span>
                                       <?php } ?> 
                            <span class="pull-right"><?= \Yii::$app->function->getAgoTime($comment->datetimestamp); ?></span>
                            <p><?= Html::encode($comment->comment);?></p>
                        </div>
                    </div>

                    <hr>
                    <?php } ?>
                  <?php else: ?>
                    <i>No user reviews yet</i>
                <?php endif; ?>
                </div>
            </div>
            <div class="col-md-4">
<div class="panel panel-default media block-update-card" style="width:100%">
   <div class="panel-body">
        <div  style="padding: 5px 0 28px 5px">
                <div class="service-stat">
                <h4><font color="green">Sold:</font> <?= \Yii::$app->function->getSoldCount($model->post_id); ?> <span class="pull-right"><font color="gray">Queue:</font> <?= \Yii::$app->function->getQueueCount($model->post_id); ?></span></h4><hr>
                </div>
                   <div class="col-sm-9"><h2 class="price"><span><?= $model->currency; ?></span><?= $model->price; ?><span>.00</span></h2></div>
                   <div class="col-sm-3 pull-right"><h4 style="margin-top:0; margin-bottom:0"><i class="fa fa-eye"></i> <?= (PostViews::find()->where(['post_id'=>$model->post_id])->count() == 0 ? 0 : PostViews::find()->where(['post_id'=>$model->post_id])->one()->view_count);?></h4></div>
                   <div class="clear-fix"></div>
                   <div class="list-group">
                    <?php if($model->owner_id == \Yii::$app->user->getId()): ?>
                    <a href="#" class="list-group-item disabled"><i class="fa fa-money"></i> Order</a>
                    <!-- <a href="#" class="list-group-item disabled"><i class="fa fa-cart-arrow-down"></i> Add to Cart</a> -->
                  <?php elseif(PostOrder::find()->where(['user_id'=>\Yii::$app->user->getId(), 'post_id'=>$model->post_id, 'status'=>'1', 'type'=>'Awaiting approval'])->count() != 0): ?>
                  <a href="#" class="list-group-item disabled cancel-order" onclick="bootbox.confirm('Are you sure?', function(result){if(result){window.location='<?= Url::to(['post/cancelorder/'.PostOrder::find()->where(['user_id'=>\Yii::$app->user->getId(), 'post_id'=>$model->post_id, 'type'=>'Awaiting approval'])->one()->order_id]); ?>'}})">Waiting approval</a>
                  <?php else: ?>
                    <a href="<?= Url::to(['post/order/'.$model->post_id]); ?>" class="list-group-item"><i class="fa fa-money"></i> Order</a>
                  <?php endif; ?>
                    <a href="#" id ="post-like_<?= $model->post_id; ?>" class="list-group-item post-rate-button <?= (($like_e) ? 'disabled' : '')?>"><i class="fa fa-thumbs-up"></i> <?= $likes; ?></a>
                    <a href="#" id ="post-dislike_<?= $model->post_id; ?>" class="list-group-item post-rate-button <?= (($dislike_e) ? 'disabled' : '')?>"><i class="fa fa-thumbs-down"></i> <?= $dislikes; ?></a>
                </div>
                <div class="clear-fix"></div>
            </div>
   </div>
   </div>
              
            <div class="clear-fix"></div>
            <div class="service-owner">
                <div class="media block-update-card">
                  <a class="pull-left" href="#">
                    <img class="media-object update-card-MDimentions img-circle" src="<?= Yii::getAlias('@web/images/users/'.$model->owner->profilePic); ?>" alt="Service owner profile picture">
                </a>
                <div class="media-body update-card-body">
                    <h4 class="media-heading owner-name"><?=  Html::encode($model->owner->fname), ' ' ,  Html::encode($model->owner->lname); ?></h4>
                    <div class="social">
                         <a href="<?= Html::encode($model->owner->facebook_url); ?>" class="[ social-icon facebook ] animate" <?php if($model->owner->facebook_url): echo ''; else: echo 'disabled'; endif;?>><span class="fa fa-facebook"></span></a>

            <a href="<?= Html::encode($model->owner->twitter_url);?>" class="[ social-icon twitter ] animate" <?php if($model->owner->twitter_url): echo ''; else: echo 'disabled'; endif;?>><span class="fa fa-twitter"></span></a>

            <a href="<?= Html::encode($model->owner->google_url); ?>" class="[ social-icon google-plus ] animate" <?php if($model->owner->google_url): echo ''; else: echo 'disabled'; endif;?>><span class="fa fa-google-plus"></span></a>

            <a href="<?= Html::encode($model->owner->linkedin_url);?>" class="[ social-icon linkedin ] animate" <?php if($model->owner->linkedin_url): echo ''; else: echo 'disabled'; endif;?>><span class="fa fa-linkedin"></span></a>
                    </div>
                    <a href="<?= Url::to(['user/profile/'.$model->owner->display_name]); ?>" class="pull-right">View profile</a>
                </div>
            </div>
            <div class="block-update-card">

              <div class="update-card-body">
              
                  <div class="col-sm-12">
                      <div class="col-sm-6">
                          <b>Location</b><br>
                         <?= Html::encode($model->owner->address); ?><br><br>
                      </div>
                      <div class="col-sm-6">
                          <b>Age</b><br>
                          23 years<br><br>
                      </div>
                  </div>
                  <div class="col-sm-12">
                      <div class="col-sm-6">
                          <b>Hobby</b><br>
                          Singing, Dancing, Music, Travel
                      </div>
                      <div class="col-sm-6">
                          <b>Joined date</b><br>
                          <?= date('F d Y', strtotime($model->owner->created_at)); ?>
                      </div>
                  </div>
              </div>
              </div>
              <div class="block-update-card">

                  <div class="update-card-body">
                      <h4>About me</h4>
                      <p><?= Html::encode($model->owner->about); ?></p>
                      </div>
                  </div>
              </div>
          </div>


      </div>

  </div>
  <!-- /.container -->
