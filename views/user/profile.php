<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\PostViews;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
?>

<div class="cover-image">
    <img src="<?= Yii::getAlias('@web/images/default-cover.jpg')?>" class="img-responsive">
</div>
<div class="container profile">
    <div class="container">
        <div class="row user-menu-container square">
            <div class="col-md-7 user-details">
                <div class="row coralbg white">
                    <div class="col-md-8 no-pad">
                        <div class="user-pad">
                            <h3><?= $user->fname, ' ', $user->lname; ?></h3>
                            <h4 class="white">(member since <?= date('F d Y', strtotime($user->created_at)); ?>)</h4>
                            <h4 class="white"><i class="fa fa-globe"></i> <?= $user->address; ?></h4>
                            <h4 class="white"><i class="fa fa-twitter"></i> sumeetbajra</h4>
                        <!-- <button type="button" class="btn btn-labeled btn-info" href="#">
                        <span class="btn-label"><i class="fa fa-pencil"></i></span>Update</button> -->
                    </div>
                </div>
                <div class="col-md-4 no-pad">
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
                    <h4><?= \Yii::$app->function->getPostedServices($user->user_id); ?></h4>
                </div>
                <div class="col-md-3 user-pad text-center">
                    <h3>SOLD</h3>
                    <h4><?= \Yii::$app->function->getSoldServices($user->user_id); ?></h4>
                </div>
                <div class="col-md-3 user-pad text-center">
                    <h3>BOUGHT</h3>
                    <h4><?= \Yii::$app->function->getBoughtServices($user->user_id); ?></h4>
                </div>
                <div class="col-md-3 user-pad text-center">
                    <h3>RATING</h3>
                    <?php $rating = \Yii::$app->function->getUserRating($user->user_id); ?>
                    <?php if ($rating != 0) : ?>
                    <?php for ($i=1; $i <= $rating['full'] ; $i++) { ?>
                    <span class="glyphicon glyphicon-star"></span>                        
                    <?php } ?>
                    <?php for ($i=1; $i <= $rating['half'] ; $i++) { ?>
                    <span class="fa fa-star-half"></span>
                    <?php } ?>
                    <br><i><?= $rating['count']?> reviews</i>
                <?php else: ?>
                <?php for ($i=1; $i <= 5 ; $i++) { ?>
                <span class="glyphicon glyphicon-star-empty"></span>
                <?php } ?>
                <br><i>0 reviews</i>
            <?php endif; ?>
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
                <?php if($user->user_id != \Yii::$app->user->getId()): ?>
                <?php $form = ActiveForm::begin(['action'=>['user/sendmessage/'.$user->display_name]]);?>
                <?= $form->field($model, 'subject')->textInput(['placeholder'=>'Subject']);?>
                <?= $form->field($model, 'message')->textarea(['placeholder'=>'Type your message', 'rows'=>'5']);?>
                <?= Html::activeHiddenInput($model, 'to_user', ['value'=>$user->user_id]); ?>
                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#captcha">Submit</a>
                <div class="modal fade" id="captcha" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">Prove that you are a human</h4>
                            </div>
                            <div class="modal-body">
                                Please type in the following captcha:
                                <?= $form->field($model, 'captcha')->widget(Captcha::className()) ?>
                            </div>
                            <div class="modal-footer">
                             <?= Html::submitButton('Send', ['class' => 'btn pull-right', 'name' => 'message-button']) ?>
                         </div>
                     </div><!-- /.modal-content -->
                 </div><!-- /.modal-dialog -->
             </div><!-- /.modal -->
            <?php else: ?>
            Here other users can send you private messages.
            <?php endif; ?>
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
<br>
<div class="row">
    <div class="col-lg-12">
        <h3>Posted by the user</h3>
        <hr>
    </div>
</div>
<!-- /.row -->

<!-- Page Features -->
<div class="row text-center">
    <?php if(count($posts) > 0): ?>
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
<div class="pull-left" style="margin-top:-30px"><a href="#">View All <i class="fa fa-angle-double-right"></i></a></div><br>
<?php else: ?>
    </div>
    <i>You have not posted any services yet. Go ahead and <a href='" . Url::to(['post/create']) . "'>create</a> one now</i><br><br>
<?php endif; ?>
<div class="container">
    <div class="row">
        <h3>User Reviews</h3>
        <hr>
    </div>
</div>
<div class="carousel-reviews broun-block">
    <div class="container">
        <div class="row">
            <div id="carousel-reviews" class="carousel slide" data-ride="carousel">

                <div class="carousel-inner">
                    <div class="item active">
                        <?php if(count($comments) > 0): ?>
                        <?php foreach($comments as $comment){ ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="block-text rel zmin">

                                <div class="mark">My rating: 
                                    <span class="rating-input">
                                       <?php for($i = 1; $i <= $comment->stars; $i++){ ?>
                                       <span class="glyphicon glyphicon-star"></span>
                                       <?php } ?> 
                                       <?php for($i = 1; $i <= 5 - $comment->stars; $i++){ ?>
                                       <span class="glyphicon glyphicon-star-empty"></span>
                                       <?php } ?> 
                                   </span></div>
                                   <div class="profile-comment">
                                   <p><?= $comment->comment; ?></p>
                               </div>
                                   <ins class="ab zmin sprite sprite-i-triangle block"></ins>
                               </div>
                               <div class="person-text rel" style="width:65px; margin: 0 auto">
                                <div class="comment-img">
                                    <img src="<?= \Yii::getAlias('@web/images/users/'.$comment->commentBy->profilePic); ?>" class="img-responsive img-circle"/>
                                    <img src = "<?= \Yii::getAlias('@web/images/users/shadow.png'); ?>" class="shadow-img">
                                </div>
                                <a title="User profile" style="margin-top: -8px" href="<?= Url::to(['user/profile/'.$comment->commentBy->display_name]);?>"><?= $comment->commentBy->display_name?></a>
                                <!--     <i>from <?= $comment->commentBy->address; ?></i> -->
                            </div>
                        </div>

                        <?php }?>
                    <?php else: ?>
                    <i>The user does not have any reviews yet</i><br>
                <?php endif; ?>


        <!--                 <div class="col-md-4 col-sm-6 hidden-xs">
                            <div class="block-text rel zmin">
                                <div class="mark">My rating: <span class="rating-input"><span data-value="0" class="glyphicon glyphicon-star"></span><span data-value="1" class="glyphicon glyphicon-star"></span><span data-value="2" class="glyphicon glyphicon-star-empty"></span><span data-value="3" class="glyphicon glyphicon-star-empty"></span><span data-value="4" class="glyphicon glyphicon-star-empty"></span><span data-value="5" class="glyphicon glyphicon-star-empty"></span>  </span></div>
                                <p>The 2013 movie "The Purge" left a bad taste in all of our mouths as nothing more than a pseudo-slasher with a hamfisted plot, poor pacing, and a desperate attempt at "horror." Upon seeing the first trailer for "The Purge: Anarchy," my first and most immediate thought was "we really don't need another one of these."  </p>
                                <ins class="ab zmin sprite sprite-i-triangle block"></ins>
                            </div>
                            <div class="person-text rel">
                                <img src="data:image/png;base64,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"/>
                                <a title="" href="#">Ella Mentree</a>
                                <i>United States</i>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 hidden-sm hidden-xs">
                            <div class="block-text rel zmin">
                                <div class="mark">My rating: <span class="rating-input"><span data-value="0" class="glyphicon glyphicon-star"></span><span data-value="1" class="glyphicon glyphicon-star"></span><span data-value="2" class="glyphicon glyphicon-star"></span><span data-value="3" class="glyphicon glyphicon-star"></span><span data-value="4" class="glyphicon glyphicon-star"></span><span data-value="5" class="glyphicon glyphicon-star"></span>  </span></div>
                                <p>What a funny and entertaining film! I did not know what to expect, this is the fourth film in this vehicle's universe with the two Cars movies and then the first Planes movie. I was wondering if maybe Disney pushed it a little bit. However, Planes: Fire and Rescue is an entertaining film that is a fantastic sequel in this magical franchise. </p>
                                <ins class="ab zmin sprite sprite-i-triangle block"></ins>
                            </div>
                            <div class="person-text rel">
                                <img src="data:image/png;base64,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"/>
                                <a title="" href="#">Rannynm</a>
                                <i>Indonesia</i>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="col-md-4 col-sm-6">
                            <div class="block-text rel zmin">
                                <a title="" href="#">Hercules</a>
                                <div class="mark">My rating: <span class="rating-input"><span data-value="0" class="glyphicon glyphicon-star"></span><span data-value="1" class="glyphicon glyphicon-star"></span><span data-value="2" class="glyphicon glyphicon-star"></span><span data-value="3" class="glyphicon glyphicon-star"></span><span data-value="4" class="glyphicon glyphicon-star-empty"></span><span data-value="5" class="glyphicon glyphicon-star-empty"></span>  </span></div>
                                <p>Never before has there been a good film portrayal of ancient Greece's favourite myth. So why would Hollywood start now? This latest attempt at bringing the son of Zeus to the big screen is brought to us by X-Men: The last Stand director Brett Ratner. If the name of the director wasn't enough to dissuade ...</p>
                                <ins class="ab zmin sprite sprite-i-triangle block"></ins>
                            </div>
                            <div class="person-text rel">
                                <img alt="" src="http://myinstantcms.ru/images/img13.png">
                                <a title="" href="#">Anna</a>
                                <i>from Glasgow, Scotland</i>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 hidden-xs">
                            <div class="block-text rel zmin">
                                <a title="" href="#">The Purge: Anarchy</a>
                                <div class="mark">My rating: <span class="rating-input"><span data-value="0" class="glyphicon glyphicon-star"></span><span data-value="1" class="glyphicon glyphicon-star"></span><span data-value="2" class="glyphicon glyphicon-star-empty"></span><span data-value="3" class="glyphicon glyphicon-star-empty"></span><span data-value="4" class="glyphicon glyphicon-star-empty"></span><span data-value="5" class="glyphicon glyphicon-star-empty"></span>  </span></div>
                                <p>The 2013 movie "The Purge" left a bad taste in all of our mouths as nothing more than a pseudo-slasher with a hamfisted plot, poor pacing, and a desperate attempt at "horror." Upon seeing the first trailer for "The Purge: Anarchy," my first and most immediate thought was "we really don't need another one of these."  </p>
                                <ins class="ab zmin sprite sprite-i-triangle block"></ins>
                            </div>
                            <div class="person-text rel">
                                <img alt="" src="http://myinstantcms.ru/images/img14.png">
                                <a title="" href="#">Ella Mentree</a>
                                <i>United States</i>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 hidden-sm hidden-xs">
                            <div class="block-text rel zmin">
                                <a title="" href="#">Planes: Fire & Rescue</a>
                                <div class="mark">My rating: <span class="rating-input"><span data-value="0" class="glyphicon glyphicon-star"></span><span data-value="1" class="glyphicon glyphicon-star"></span><span data-value="2" class="glyphicon glyphicon-star"></span><span data-value="3" class="glyphicon glyphicon-star"></span><span data-value="4" class="glyphicon glyphicon-star"></span><span data-value="5" class="glyphicon glyphicon-star"></span>  </span></div>
                                <p>What a funny and entertaining film! I did not know what to expect, this is the fourth film in this vehicle's universe with the two Cars movies and then the first Planes movie. I was wondering if maybe Disney pushed it a little bit. However, Planes: Fire and Rescue is an entertaining film that is a fantastic sequel in this magical franchise. </p>
                                <ins class="ab zmin sprite sprite-i-triangle block"></ins>
                            </div>
                            <div class="person-text rel">
                                <img alt="" src="http://myinstantcms.ru/images/img15.png">
                                <a title="" href="#">Rannynm</a>
                                <i>Indonesia</i>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="col-md-4 col-sm-6">
                            <div class="block-text rel zmin">
                                <a title="" href="#">Hercules</a>
                                <div class="mark">My rating: <span class="rating-input"><span data-value="0" class="glyphicon glyphicon-star"></span><span data-value="1" class="glyphicon glyphicon-star"></span><span data-value="2" class="glyphicon glyphicon-star"></span><span data-value="3" class="glyphicon glyphicon-star"></span><span data-value="4" class="glyphicon glyphicon-star-empty"></span><span data-value="5" class="glyphicon glyphicon-star-empty"></span>  </span></div>
                                <p>Never before has there been a good film portrayal of ancient Greece's favourite myth. So why would Hollywood start now? This latest attempt at bringing the son of Zeus to the big screen is brought to us by X-Men: The last Stand director Brett Ratner. If the name of the director wasn't enough to dissuade ...</p>
                                <ins class="ab zmin sprite sprite-i-triangle block"></ins>
                            </div>
                            <div class="person-text rel">
                                <img alt="" src="http://myinstantcms.ru/images/img13.png">
                                <a title="" href="#">Anna</a>
                                <i>from Glasgow, Scotland</i>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 hidden-xs">
                            <div class="block-text rel zmin">
                                <a title="" href="#">The Purge: Anarchy</a>
                                <div class="mark">My rating: <span class="rating-input"><span data-value="0" class="glyphicon glyphicon-star"></span><span data-value="1" class="glyphicon glyphicon-star"></span><span data-value="2" class="glyphicon glyphicon-star-empty"></span><span data-value="3" class="glyphicon glyphicon-star-empty"></span><span data-value="4" class="glyphicon glyphicon-star-empty"></span><span data-value="5" class="glyphicon glyphicon-star-empty"></span>  </span></div>
                                <p>The 2013 movie "The Purge" left a bad taste in all of our mouths as nothing more than a pseudo-slasher with a hamfisted plot, poor pacing, and a desperate attempt at "horror." Upon seeing the first trailer for "The Purge: Anarchy," my first and most immediate thought was "we really don't need another one of these."  </p>
                                <ins class="ab zmin sprite sprite-i-triangle block"></ins>
                            </div>
                            <div class="person-text rel">
                                <img alt="" src="http://myinstantcms.ru/images/img14.png">
                                <a title="" href="#">Ella Mentree</a>
                                <i>United States</i>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 hidden-sm hidden-xs">
                            <div class="block-text rel zmin">
                                <a title="" href="#">Planes: Fire & Rescue</a>
                                <div class="mark">My rating: <span class="rating-input"><span data-value="0" class="glyphicon glyphicon-star"></span><span data-value="1" class="glyphicon glyphicon-star"></span><span data-value="2" class="glyphicon glyphicon-star"></span><span data-value="3" class="glyphicon glyphicon-star"></span><span data-value="4" class="glyphicon glyphicon-star"></span><span data-value="5" class="glyphicon glyphicon-star"></span>  </span></div>
                                <p>What a funny and entertaining film! I did not know what to expect, this is the fourth film in this vehicle's universe with the two Cars movies and then the first Planes movie. I was wondering if maybe Disney pushed it a little bit. However, Planes: Fire and Rescue is an entertaining film that is a fantastic sequel in this magical franchise. </p>
                                <ins class="ab zmin sprite sprite-i-triangle block"></ins>
                            </div>
                            <div class="person-text rel">
                                <img alt="" src="http://myinstantcms.ru/images/img15.png">
                                <a title="" href="#">Rannynm</a>
                                <i>Indonesia</i>
                            </div>
                        </div> -->
                    </div>                    
                </div>
                <a class="left carousel-control" href="#carousel-reviews" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-reviews" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
        </div>
    </div>
</div>



   <!--  <div class="col-md-12">
    <div class="col-md-2 col-sm-4 text-center">
        <div class="user-comment">
<div class="profile-img" style="width: 80px; margin: 0 auto">
    <img src = "<?= \Yii::getAlias('@web/images/users/default.jpg'); ?>" class="img-responsive img-circle">
    <h4 class="montserrat">Sumit</h4>
    <font size="2">
    <span class="glyphicon glyphicon-star"></span>
    <span class="glyphicon glyphicon-star"></span>
    <span class="glyphicon glyphicon-star"></span>
    <span class="glyphicon glyphicon-star-empty"></span>
    <span class="glyphicon glyphicon-star-empty"></span>
</font><br><br>

Great experience. Thank you.
</div>
</div>
    </div>
    <div class="col-md-2 col-sm-4">
<div class="user-comment">
test
</div>
    </div>
    <div class="col-md-2 col-sm-4">
<div class="user-comment">
test
</div>
    </div>
    <div class="col-md-2 col-sm-4">
<div class="user-comment">
test
</div>
    </div>
    <div class="col-md-2 col-sm-4">
<div class="user-comment">
test
</div>
    </div>
    <div class="col-md-2 col-sm-4">
<div class="user-comment">
test
</div>
    </div>
</div>
<div class="clear-fix"></div> -->
       <!--  <div class="panel panel-default widget">
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
                            </div> -->