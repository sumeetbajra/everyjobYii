<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?= Html::csrfMetaTags() ?>

    <title>Everyjob - Job for everyone</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= Yii::getAlias('@web'); ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web'); ?>/css/custom.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= Yii::getAlias('@web'); ?>/css/heroic-features.css" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web'); ?>/css/fileinput.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>


    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand logo">everyjob</span>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-right" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                         <li>
                            <a href="<?= Url::to(['site/index'])?>">Home</a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['site/about'])?>">About</a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['site/index'])?>">Services</a>
                        </li>
                         <?php  if(Yii::$app->user->isGuest) : ?>
                        <li>
                            <a href="<?= Url::to(['site/register'])?>">Register</a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#myModal">Sign In</a>
                        </li>
                          <?php else: ?>
                           <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Profile <span class="caret"></span></a>
          <ul class="dropdown-menu profile-side-menu" role="menu">
            <li><a href="#"><i class="fa fa-tachometer"></i> Dashboard</a></li>
              <li><a href="<?= Url::to(['post/create']) ?>"><i class="fa fa-plus"></i> Create a post</a></li>
        <li><a><i class="fa fa-tasks"></i> Active tasks</a></li>
        <li><a><i class="fa fa-envelope"></i> Messeges (0)</a></li>
        <li><a><i class="fa fa-globe"></i> Notifications (0)</a></li>
        <li><a><i class="fa fa-cogs"></i> Profile Settings</a></li>
          </ul>
        </li>
                          <li><a href= '<?= Url::to(["site/logout"]) ?>' data-method = 'POST'>Logout (<?= Yii::$app->user->identity->display_name ?>)</li>
                          <?php endif; ?>
                        
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

<div class="container">

<div class="row">
        <?= $content; ?>
    </div>
</div>
       
  <!-- Footer -->
  
        <footer>
            <div class="container">
                <div class="row">
                    <!-- About -->
                    <div class="col-md-3 md-margin-bottom-40">
                        <a href="index.html" class="logo">everyjob</a>
                        <p>About Unify dolor sit amet, consectetur adipiscing elit. Maecenas eget nisl id libero tincidunt sodales.</p>
                        <p>Duis eleifend fermentum ante ut aliquam. Cras mi risus, dignissim sed adipiscing ut, placerat non arcu.</p>    
                    </div><!--/col-md-3-->
                    <!-- End About -->

                    <!-- Latest -->
                    <div class="col-md-3 md-margin-bottom-40">
                        <div class="posts">
                            <div class="headline"><h2>Latest Posts</h2></div>
                            <ul class="list-unstyled latest-list">
                                <li>
                                    <a href="#">Incredible content</a>
                                    <small>May 8, 2014</small>
                                </li>
                                <li>
                                    <a href="#">Best shoots</a>
                                    <small>June 23, 2014</small>
                                </li>
                                <li>
                                    <a href="#">New Terms and Conditions</a>
                                    <small>September 15, 2014</small>
                                </li>
                            </ul>
                        </div>
                    </div><!--/col-md-3-->  
                    <!-- End Latest --> 
                    
                    <!-- Link List -->
                    <div class="col-md-3 md-margin-bottom-40">
                        <div class="headline"><h2>Useful Links</h2></div>
                        <ul class="list-unstyled link-list">
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Portfolio</a></li>
                            <li><a href="#">Latest jobs</a></li>
                            <li><a href="#">Community</a></li>
                            <li><a href="#">Contact us</a></li>
                        </ul>
                    </div><!--/col-md-3-->
                    <!-- End Link List -->                    

                    <!-- Address -->
                    <div class="col-md-3 map-img md-margin-bottom-40">
                        <div class="headline"><h2>Contact Us</h2></div>                         
                        <address class="md-margin-bottom-40">
                            25, Lorem Lis Street, Orange <br>
                            California, US <br>
                            Phone: 800 123 3456 <br>
                            Fax: 800 123 3456 <br>
                            Email: <a href="mailto:info@anybiz.com" class="">info@anybiz.com</a>
                        </address>
                    </div><!--/col-md-3-->
                    <!-- End Address -->
                </div>
            </div> 
        </footer><!--/footer-->

        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">                     
                        <p>
                            2014 © All Rights Reserved.
                           <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
                        </p>
                    </div>

                    <!-- Social Links -->
                    <div class="col-md-6">
                        <ul class="footer-socials list-inline">
                            <li>
                                <a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Skype">
                                    <i class="fa fa-skype"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Google Plus">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Linkedin">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Pinterest">
                                    <i class="fa fa-pinterest"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Dribbble">
                                    <i class="fa fa-dribbble"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Social Links -->
                </div>
            </div> 
        </div><!--/copyright-->
    
<!--   <footer>
    <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <p>Copyright &copy; Everyjob 2015</p>
        </div>
    </div>
</div>
</footer> -->



<!-- jQuery -->
<script src="<?= Yii::getAlias('@web'); ?>/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?= Yii::getAlias('@web'); ?>/js/bootstrap.min.js"></script>
<script src="<?= Yii::getAlias('@web'); ?>/js/fileinput.min.js"></script>
<script src="<?= Yii::getAlias('@web'); ?>/js/custom.js"></script>

</body>


</html>
<?php $this->endPage() ?>