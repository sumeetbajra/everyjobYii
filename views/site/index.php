<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\User;
use app\models\PostViews;
?>

 <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">
          <!-- Overlay -->
          <div class="overlay"></div>

          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#bs-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#bs-carousel" data-slide-to="1"></li>
            <li data-target="#bs-carousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item slides active">
              <div class="slide-1"></div>
              <div class="overlay"></div>
              <div class="hero">
                <hgroup>
                    <h1>Showcase your skills</h1>        
                    <h3>Show people that you are awesome</h3>
                </hgroup>
                <button class="btn btn-hero btn-lg" role="button">Get Started</button>
            </div>
        </div>
        <div class="item slides">
          <div class="slide-2"></div>
          <div class="overlay"></div>
          <div class="hero">        
            <hgroup>
                <h1>Get your things done</h1>        
                <h3>Search, order, receive. Quick and easy</h3>
            </hgroup>       
            <button class="btn btn-hero btn-lg" role="button">Get Started</button>
        </div>
    </div>
    <div class="item slides">
      <div class="slide-3"></div>
      <div class="overlay"></div>
      <div class="hero">        
        <hgroup>
            <h1>Safety and trust</h1>        
            <h3>Your safety is our first priority</h3>
        </hgroup>
        <button class="btn btn-hero btn-lg" role="button">See all features</button>
    </div>
</div>
</div> 
</div>


      <!--   <div class="homepage-banner">
            <div class="banner-text">
            <h1>A Warm Welcome!</h1>
               <p id="backgrounded">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>
               <p><a class="btn btn-primary btn-large">Get Started!</a>
               </p>
           </div>
       </div> -->
       <!-- Jumbotron Header -->
      <!--   <header class="jumbotron hero-spacer">
            <h1>A Warm Welcome!</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>
            <p><a class="btn btn-primary btn-large">Call to action!</a>
            </p>
        </header> -->

        <!-- Page Content -->
        <div class="container">
         <br>
         <hr>

         <div class="row">
            <div class="col-md-4">
                <div class="service">
                    <div class="desc">
                        <h4><i class="fa fa-arrow-circle-o-up"></i> Post Services</h4>
                        <p>Show people what you can do. Give a short description abou the service and fix a price. You are ready to start earning.</p>
                    </div>
                </div>  
            </div>
            <div class="col-md-4">
                <div class="service">
                    <div class="desc">
                        <h4><i class="fa fa-shopping-cart"></i> Fulfill Your Needs</h4>
                        <p>Search among the pool of thousands of services posted by the freelancers. Get your things done easy and quick.</p>
                    </div>
                </div>  
            </div>
            <div class="col-md-4">
                <div class="service">
                    <div class="desc">
                        <h4><i class="fa fa-lock"></i> Safety and Trust</h4>
                        <p>The trasactions through the site are completely secured and safe. Your security is our first priority</p>
                    </div>
                </div>  
            </div>              
        </div>     

        <hr>

        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Most Trending</h3>
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
                    <span class="pull-left" style="position: relative; top: -16px">by <b><a href="<?= Url::to(['user/profile/'.$post->owner->display_name]); ?>"><?= User::findIdentity($post->owner_id)->display_name; ?></b></a></span>
                    <span class="pull-right" style="position: relative; top: -16px"><i class="fa fa-eye"></i> <?= (PostViews::find()->where(['post_id'=>$post->post_id])->count() == 0 ? 0 : PostViews::find()->where(['post_id'=>$post->post_id])->one()->view_count);?> &nbsp;<i class="fa fa-thumbs-up"></i> <?= $ratings->postRating($post->post_id)['likes'];?> &nbsp;<i class="fa fa-thumbs-down"></i> <?= $ratings->postRating($post->post_id)['dislikes'];?></span>
                </div>
            </div>
           
     <?php  } ?>

            
                <div class="pull-right"><a href="#">View All <i class="fa fa-angle-double-right"></i></a></div>
            </div>
            <!-- /.row -->
            <hr>

            <div class="row">
               <div class="col-lg-12">
                <h3>Categories</h3><br>
            </div>
            <div class="carousel slide" id="myCarousel">
              <div class="carousel-inner">
                <div class="item active">
                  <div class="col-lg-4 col-xs-4 col-md-4 col-sm-4">
                      <a href="#"><img src="<?= Yii::getAlias('@web'); ?> /images/categories/1.jpg" class="img-responsive"></a>
                      <span class="category-caption ">Article Writing & Editing</span>
                  </div>
              </div>
              <div class="item">
                  <div class="col-lg-4 col-xs-4 col-md-4 col-sm-4">
                      <a href="#"><img src="<?= Yii::getAlias('@web'); ?> /images/categories/2.png" class="img-responsive"></a>
                      <span class="category-caption ">Web Designing</span>
                  </div>
              </div>
              <div class="item">
                  <div class="col-lg-4 col-xs-4 col-md-4 col-sm-4">
                      <a href="#"><img src="<?= Yii::getAlias('@web'); ?> /images/categories/3.png" class="img-responsive"></a>
                      <span class="category-caption ">Graphics and Desgn</span>
                  </div>
              </div>
              <div class="item">
                  <div class="col-lg-4 col-xs-4 col-md-4 col-sm-4">
                      <a href="#"><img src="<?= Yii::getAlias('@web'); ?> /images/categories/4.jpg" class="img-responsive"></a>
                      <span class="category-caption ">Computer and Programming</span>
                  </div>
              </div>
              <div class="item">
                  <div class="col-lg-4 col-xs-4 col-md-4 col-sm-4">
                      <a href="#"><img src="<?= Yii::getAlias('@web'); ?> /images/categories/5.jpg" class="img-responsive"></a>
                      <span class="category-caption ">Multimedia & Editing</span>
                  </div>
              </div>
          </div>
          <a class="left carousel-control" href="#myCarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
          <a class="right carousel-control" href="#myCarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
      </div>
  </div>

  </div>
<!-- /.container -->

<!--login modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div id="login-overlay" class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title" id="myModalLabel">Login to everyjob</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-xs-6">
                      <div class="well">                    	
          <?php $form = ActiveForm::begin([
        'id' => 'loginForm',
        'method'=>'POST',
        'action' => ['site/login'],
        /*'enableAjaxValidation' => true,*/
        'fieldConfig' => [
            //'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'template' => "<div class=\"form-group\">{label}\n{input}</div>\n{error}",
            'labelOptions' => ['class' => 'control-label'],
            'inputOptions' => ['class'=>'form-control'],
        ],
    ]); ?>

<?= $form->errorSummary($model); ?>
    <?= $form->field($model, 'email', ['options'=>['id'=>'email', 'placeholder'=>'example@gmail.com']])->label('Email')->input('email'); ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe', ['options'=>['class'=>'']])->checkbox() ?>



<p class="help-block">(if this is a private computer)</p>
                       
        <?= Html::submitButton('Login', ['class' => 'btn btn-success btn-block', 'name' => 'login-button']) ?>
            <a href="/forgot/" class="btn btn-default btn-block">Help to login</a>
            <?php ActiveForm::end(); ?>


    
        </div>
    </div>

                        
                  <div class="col-xs-6">
                      <p class="lead">Register now for <span class="text-success">FREE</span></p>
                      <ul class="list-unstyled" style="line-height: 2">
                          <li><span class="fa fa-check text-success"></span> Showcase your skills</li>
                          <li><span class="fa fa-check text-success"></span> Get your work done</li>
                          <li><span class="fa fa-check text-success"></span> Secure transactions</li>
                          <li><span class="fa fa-check text-success"></span> Fast Checkout</li>
                          <li><span class="fa fa-check text-success"></span> Support Nepalese currency</li>
                          <li><a href="/read-more/"><u>Read more</u></a></li>
                      </ul>
                      <p><a href="/new-customer/" class="btn btn-info btn-block">Yes please, register now!</a></p>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<!--login modal ends-->
