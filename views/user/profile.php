<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\PostViews;
?>

<div class="cover-image">
    <img src="<?= Yii::getAlias('@web/images/default-cover.jpg')?>" class="img-responsive">
</div>
<div class="container profile">
    <div class="container">
        <div class="row user-menu-container square">
            <div class="col-md-7 user-details">
                <div class="row coralbg white">
                    <div class="col-md-6 no-pad">
                        <div class="user-pad">
                            <h3><?= $user->fname, ' ', $user->lname; ?></h3>
                            <h4 class="white">(member since <?= date('F d Y', strtotime($user->created_at)); ?>)</h4>
                            <h4 class="white"><i class="fa fa-globe"></i> <?= $user->address; ?></h4>
                            <h4 class="white"><i class="fa fa-twitter"></i> sumeetbajra</h4>
                        <!-- <button type="button" class="btn btn-labeled btn-info" href="#">
                        <span class="btn-label"><i class="fa fa-pencil"></i></span>Update</button> -->
                    </div>
                </div>
                <div class="col-md-6 no-pad">
                    <div class="user-image">
                        <?php 
                        if($user->profilePic == 'default.jpg'){
                            $src = 'default-profile.jpg';
                        }else{
                            $src = $user->profilePic;
                        }
                        ?>
                        <img src="<?= Yii::getAlias('@web/images/users/'.$src); ?>" class="img-responsive thumbnail">
                    </div>
                </div>
            </div>
            <div class="row overview">
                <div class="col-md-3 user-pad text-center">
                    <h3>SERVICES</h3>
                    <h4>12</h4>
                </div>
                <div class="col-md-3 user-pad text-center">
                    <h3>SOLD</h3>
                    <h4>9</h4>
                </div>
                <div class="col-md-3 user-pad text-center">
                    <h3>BOUGHT</h3>
                    <h4>21</h4>
                </div>
                <div class="col-md-3 user-pad text-center">
                    <h3>RATING</h3>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                </div>
            </div>
        </div>
        <div class="col-md-1 user-menu-btns">
            <div class="btn-group-vertical square" id="responsive">
                <a href="#" class="btn btn-block btn-default active">
                  <i class="fa fa-user fa-3x"></i>
              </a>
              <a href="#" class="btn btn-default">
                  <i class="fa fa-clock-o fa-3x"></i>
              </a>
              <a href="#" class="btn btn-default">
                  <i class="fa fa-envelope-o fa-3x"></i>
              </a>
              <a href="#" class="btn btn-default">
                  <i class="fa fa-globe fa-3x"></i>
              </a>
          </div>
      </div>
      <div class="col-md-4 user-menu user-pad">
        <div class="user-menu-content active">
            <h3>
                About Me
            </h3>
            <?= $user->about; ?>           
        </div>
        <div class="user-menu-content">
            <h3>
                Recent Posts
            </h3>
            <ul class="user-menu-list">
                <?php foreach($posts as $key=>$post){ 
                    if($key <= 2):
                    ?>
                <li>
                    <h4><?= $post->title; ?></h4>
                </li>
            <?php endif; ?>
                <?php } ?>
                <li>
                    <button type="button" class="btn btn-labeled btn-danger" href="#">
                        <span class="btn-label"><i class="fa fa-eye"></i></span>View All Posts</button>
                    </li>
                </ul>
            </div>
            <div class="user-menu-content">
                <h3>
                    Contact
                </h3>
                <div class="row">
                    <textarea class="form-control" rows="5" placeholder="Type your message"></textarea><br>
                    <button class="btn pull-right">Send</button>
                </div>
            </div>
            <div class="user-menu-content">
                <h2 class="text-center">
                    Yep, thats all about me!!
                </h2>
                If there's more you want to know, you can contact me via following:<br><br>
                <div class="social">
                    <a href="https://www.facebook.com/rem.mcintosh" class="[ social-icon facebook ] animate"><span class="fa fa-facebook"></span></a>

                    <a href="https://twitter.com/Mouse0270" class="[ social-icon twitter ] animate"><span class="fa fa-twitter"></span></a>

                    <a href="https://plus.google.com/u/0/115077481218689845626/posts" class="[ social-icon google-plus ] animate"><span class="fa fa-google-plus"></span></a>

                    <a href="www.linkedin.com/in/remcintosh/" class="[ social-icon linkedin ] animate"><span class="fa fa-linkedin"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-lg-12">
        <h3>Posted by the user</h3>
        <br>
    </div>
</div>
<!-- /.row -->

<!-- Page Features -->
 <div class="row text-center">
  <?php foreach ($posts as $post) { ?>
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                <?php if($post->featured == 1) : ?>
                <div class="ribbon-wrapper-green"><div class="ribbon-green">Featured</div></div>
            <?php endif; ?>
                    <img src="<?= Yii::getAlias('@web'); ?>/images/services/<?= $post->image_url; ?>" alt="Promotional image">
                    <div class="caption">
                        <h4>Price: <?= $post->currency, ' ', $post->price; ?></h4>
                        <p><?= $post->title; ?></p>
                        <p>
                            <a href="#" class="btn btn-primary">Order Now!</a> <a href="<?= Url::to(['post/view/'.$post->post_id.'/'.$post->slug]); ?>" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                    <span class="pull-right" style="position: relative; top: -16px"><i class="fa fa-eye"></i> <?= (PostViews::find()->where(['post_id'=>$post->post_id])->count() == 0 ? 0 : PostViews::find()->where(['post_id'=>$post->post_id])->one()->view_count);?> &nbsp;<i class="fa fa-thumbs-up"></i> <?= $ratings->postRating($post->post_id)['likes'];?> &nbsp;<i class="fa fa-thumbs-down"></i> <?= $ratings->postRating($post->post_id)['dislikes'];?></span>
                </div>
            </div>
           
     <?php  } ?>
            </div>
            <div class="pull-left"><a href="#">View All <i class="fa fa-angle-double-right"></i></a></div><br>
    <hr>
    <div class="row">
        <div class="panel panel-default widget">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-comment"></span>
                <h3 class="panel-title">
                    User Reviews</h3>
                    <span class="label label-info">
                        78</span>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-xs-2 col-md-1">
                                        <img src="http://placehold.it/80" class="img-circle img-responsive" alt="" /></div>
                                        <div class="col-xs-10 col-md-11">
                                            <div>
                                                <div class="mic-info">
                                                    <a href="#">Bhaumik Patel</a> on 2 Aug 2013 said:
                                                </div>
                                                Lorem ipsum dolor sit amet. Great experience.                                    
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-xs-2 col-md-1">
                                            <img src="http://placehold.it/80" class="img-circle img-responsive" alt="" /></div>
                                            <div class="col-xs-10 col-md-11">
                                                <div>
                                                    <div class="mic-info">
                                                        <a href="#">Bhaumik Patel</a> on 2 Aug 2013 said:
                                                    </div>
                                                    Lorem ipsum dolor sit amet. Great experience.                                    
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-xs-2 col-md-1">
                                                <img src="http://placehold.it/80" class="img-circle img-responsive" alt="" /></div>
                                                <div class="col-xs-10 col-md-11">
                                                    <div>
                                                        <div class="mic-info">
                                                            <a href="#">Bhaumik Patel</a> on 2 Aug 2013 said:
                                                        </div>
                                                        Lorem ipsum dolor sit amet. Great experience.                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-xs-2 col-md-1">
                                                    <img src="http://placehold.it/80" class="img-circle img-responsive" alt="" /></div>
                                                    <div class="col-xs-10 col-md-11">
                                                        <div>
                                                            <div class="mic-info">
                                                                <a href="#">Bhaumik Patel</a> on 2 Aug 2013 said:
                                                            </div>
                                                            Lorem ipsum dolor sit amet. Great experience.                                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <a href="#" class="btn btn-primary btn-sm btn-block" role="button"><span class="glyphicon glyphicon-refresh"></span> More</a>
                                    </div>
                                </div>
                            </div>