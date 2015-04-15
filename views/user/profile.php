<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\PostViews;
use app\models\FlagReports;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
?>

<div class="cover-image">
    <img src="<?= Yii::getAlias('@web/images/default-cover.jpg')?>" class="img-responsive">
</div>

<?php if($user->user_id != \Yii::$app->user->getId()) : ?>
<div class="shortcut-links">
<a class="btn btn-danger" data-toggle="modal" data-target="#report">
    <i class="fa fa-exclamation"></i>
    </a><br>
    <a class="btn btn-primary">
        <i class="fa fa-envelope"></i>
    </a>
</div>
<?php endif; ?>

<div class="container profile">
    <div class="container">
        <div class="row user-menu-container square">
            <div class="col-md-7 user-details">
                <div class="row coralbg white">
                    <div class="col-md-8 no-pad">
                        <div class="user-pad">
                            <h3><?= Html::encode($user->fname), ' ', Html::encode($user->lname); ?></h3>
                            <h4 class="white">(member since <?= date('F d Y', strtotime($user->created_at)); ?>)</h4>
                            <h4 class="white"><i class="fa fa-globe"></i> <?= Html::encode($user->address); ?></h4>
                            <h4 class="white"><i class="fa fa-user"></i> <?= Html::encode($user->display_name); ?></h4>
                        <!-- <button type="button" class="btn btn-labeled btn-info" href="#">
                        <span class="btn-label"><i class="fa fa-pencil"></i></span>Update</button> -->
                    </div>
                </div>
                <div class="col-md-4 no-pad">
                    <div class="user-image">
                        <?php 
                        if($user->profilePic == 'default.jpg'){
                            $src = 'default.jpg';
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
        <?= Html::encode($user->about); ?>           
    </div>
    <div class="user-menu-content">
        <h3>
            Recent Posts
        </h3>
        <ul class="user-menu-list">
            <?php foreach($posts as $key=>$post){ 
                if($key <= 3):
                    ?>
                <li>
                    <a href="<?= Url::to(['post/view/'.$post->post_id.'/'.$post->slug]); ?>"><?= Html::encode($post->title); ?></a>
                </li>
            <?php endif; ?>
            <?php } ?>
            <li>
                <a class="btn btn-labeled btn-danger" href="#posts">
                    <span class="btn-label"><i class="fa fa-eye"></i></span>View All Posts</a>
                </li>
            </ul>
        </div>
        <div class="user-menu-content">
            <h3>
                Contact
            </h3>
            <div class="row">
                <?php if($user->user_id != \Yii::$app->user->getId()): ?>
                <?php $form = ActiveForm::begin(['action'=>['user/sendmessage/'.Html::encode($user->display_name)]]);?>
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
            <a href="<?= Html::encode($user->facebook_url); ?>" class="[ social-icon facebook ] animate" <?php if($user->facebook_url): echo ''; else: echo 'disabled'; endif;?>><span class="fa fa-facebook"></span></a>

            <a href="<?= Html::encode($user->twitter_url);?>" class="[ social-icon twitter ] animate" <?php if($user->twitter_url): echo ''; else: echo 'disabled'; endif;?>><span class="fa fa-twitter"></span></a>

            <a href="<?= Html::encode($user->google_url); ?>" class="[ social-icon google-plus ] animate" <?php if($user->google_url): echo ''; else: echo 'disabled'; endif;?>><span class="fa fa-google-plus"></span></a>

            <a href="<?= Html::encode($user->linkedin_url);?>" class="[ social-icon linkedin ] animate" <?php if($user->linkedin_url): echo ''; else: echo 'disabled'; endif;?>><span class="fa fa-linkedin"></span></a>
        </div>
    </div>
</div>
</div>
</div>
<a name="posts"></a>
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
            <h4>Price: <?= $post->currency, ' ', Html::encode($post->price); ?></h4>
            <p><?= Html::encode($post->title); ?></p>
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
    <?php if($user->user_id != \Yii::$app->user->getId()): ?>
         <i>This user has not posted any services yet.</i><br><br>
            <?php else: ?>
            <i>You have not posted any services yet. Go ahead and <a href='" . Url::to(['post/create']) . "'>create</a> one now</i><br><br>
            <?php endif; ?>
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
                                   <p><?= Html::encode($comment->comment); ?></p>
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
                <div class="modal fade" id="report" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="width:40%; top:30px">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">Report User</h4>
                            </div>
                            <div class="modal-body">
                                <?php 
                                $report = FlagReports::find()->where(['reported_by'=>\Yii::$app->user->getId(), 'user_id'=>$user->user_id, 'active'=>'1'])->one();
                                if(!empty($report)): ?>
                                <div class="col-md-12 alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-info-circle"></i> User Reported. Thank you for your feeback.</div><div class="clear-fix"></div>
                            <?php else: ?>
                                Please choose an appropriate reason:<br><br>  
                                        <label><input type="radio" class="report-radio" name="report" value="Fake Profile"> Fake profile</label><br>                              
                                        <label><input type="radio" class="report-radio" name="report" value="Inappropriate Content"> Inappropriate content or post</label><br>
                                        <label><input type="radio" class="report-radio" name="report" value="Spam"> Spam</label><br>
                                        <label><input type="radio" class="report-radio" name="report" value="others"> Others (Specify):</label><br><br>
                                        <textarea class="form-control input report-other hidden" placeholder="Briefly explain the reason in maximum 255 words" max="255" class="hidden"></textarea>
                                    <?php endif; ?>
                            </div>
                            <div class="modal-footer">
                                  <?php if(!empty($report)): ?>
                                  <?= Html::button('Close', ['class' => 'btn btn-primary pull-right', 'data-dismiss' => 'modal']) ?>
                              <?php else: ?>
                             <?= Html::button('Report', ['class' => 'btn btn-primary pull-right report-button', 'name' => 'report-button', 'id'=> $user->user_id ]) ?>
                         <?php endif; ?>
                         </div>
                     </div><!-- /.modal-content -->
                 </div><!-- /.modal-dialog -->
             </div><!-- /.modal -->
