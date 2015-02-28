<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\PostViews;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PostServices */

?>
 <!-- Page Content -->
    <div class="container">
        <div class="row">

            <div class="col-md-8">

                <div class="thumbnail">
                    <h3 class="service-title"><?= $model->title; ?></h3>
                    <hr>
                    <span>by <a target="_blank" href="http://bootsnipp.com"><?= $model->owner->display_name; ?></a></span>&nbsp;&nbsp;
                    <span><i class="fa fa-calendar"></i> <?=  date('F d Y', strtotime($model->datetimestamp)); ?></span>&nbsp;&nbsp;
                    <span>Category: <a href="#"><?= $model->category->category_name; ?></a></span><br><br>
                    <img class="img-responsive img-thumbnail" src="<?= Yii::getAlias('@web/images/services/'.$model->image_url)?>" alt="Promotional image for the service post">
                    <div class="caption-full">
                        <h3>Service Description</h3><hr>
                        <p><?= $model->description; ?></p>
                    </div>
                    <div class="clear-fix"></div>
                    <div class="ratings">
                        <p class="pull-right">3 reviews</p>
                        <p>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            4.0 stars
                        </p>
                    </div>
                </div>

                <div class="well">

                    <div class="text-right">
                        <a class="btn btn-success">Leave a Review</a>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            Anonymous
                            <span class="pull-right">10 days ago</span>
                            <p>This product was great in terms of quality. I would definitely buy another!</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            Anonymous
                            <span class="pull-right">12 days ago</span>
                            <p>I've alredy ordered another one!</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            Anonymous
                            <span class="pull-right">15 days ago</span>
                            <p>I've seen some better than this, but not at this price. I definitely recommend this item.</p>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-md-4">


<div class="panel panel-default media block-update-card" style="width:100%">
  
   <div class="panel-body">
        <div  style="padding: 5px 0 28px 5px">
                <div class="service-stat">
                <h4><font color="green">Sold:</font> 4532 <span class="pull-right"><font color="gray">Queue:</font> 34</span></h4><hr>
                </div>
                   <div class="col-sm-9"><h2 class="price"><span><?= $model->currency; ?></span><?= $model->price; ?><span>.00</span></h2></div>
                   <div class="col-sm-3 pull-right"><h4 style="margin-top:0; margin-bottom:0"><i class="fa fa-eye"></i> <?= (PostViews::find()->where(['post_id'=>$model->post_id])->count() == 0 ? 0 : PostViews::find()->where(['post_id'=>$model->post_id])->one()->view_count);?></h4></div>
                   <div class="clear-fix"></div>
                   <div class="list-group">
                    <a href="<?= Url::to(['post/order/'.$model->post_id]); ?>" class="list-group-item"><i class="fa fa-money"></i> Order</a>
                    <a href="#" class="list-group-item"><i class="fa fa-cart-arrow-down"></i> Add to Cart</a>
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
                    <h4 class="media-heading owner-name"><?=  $model->owner->fname, ' ' ,  $model->owner->lname; ?></h4>
                    <div class="social">
                        <a href="https://www.facebook.com/rem.mcintosh" class="[ social-icon facebook ] animate"><span class="fa fa-facebook"></span></a>

                        <a href="https://twitter.com/Mouse0270" class="[ social-icon twitter ] animate"><span class="fa fa-twitter"></span></a>

                        <a href="https://plus.google.com/u/0/115077481218689845626/posts" class="[ social-icon google-plus ] animate"><span class="fa fa-google-plus"></span></a>

                        <a href="www.linkedin.com/in/remcintosh/" class="[ social-icon linkedin ] animate"><span class="fa fa-linkedin"></span></a>
                    </div>
                    <a href="<?= Url::to(['user/profile/'.$model->owner->display_name]); ?>" class="pull-right">View profile</a>
                </div>
            </div>
            <div class="block-update-card">

              <div class="update-card-body">
              
                  <div class="col-sm-12">
                      <div class="col-sm-6">
                          <b>Location</b><br>
                         <?= $model->owner->address; ?><br><br>
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
                      <p><?= $model->owner->about; ?></p>
                      </div>
                  </div>
              </div>
          </div>


      </div>

  </div>
  <!-- /.container -->
