<?php
use yii\helpers\Url;
?>

<div class="row">
<div class="well">
Welcome admin!! You are in the backend of the website. Below are the available facilities to you</div>

<div class="row">
<div class="col-md-8">
<div class="panel panel-primary">
  <div class="panel-heading">Admin menu</div>
  <div class="panel-body">
    <div class="col-sm-3">
    <div class="classWithPadding well text-center"><a href="<?= Url::to(['category/index'])?>">
    <font size="8"><i class="fa fa-th-list"></i></font><br>
    Manage Categories
    </a>
    </div>
    </div>
    <div class="col-sm-3">
    <div class="classWithPadding well text-center">
    <font size="8"><i class="fa fa-money"></i></font><br>
    Cash withdrawal
    </div>
    </div>
    <div class="col-sm-3">
    <div class="classWithPadding well text-center">
    <font size="8"><i class="fa fa-flag"></i></font><br>
    User reports
    </div>
    </div>
    <div class="col-sm-3">
    <div class="classWithPadding well text-center">
    <font size="8"><i class="fa fa-bookmark"></i></font><br>
    Featured posts
    </div>
    </div>
  </div>
</div>
</div>
<div class="col-md-4">
<div class="panel panel-success">
  <div class="panel-heading">Quick links</div>
  <div class="panel-body">
  <ul class="quick-links">
  <li>
    <i class="fa fa-user"></i> Registered users<br></li>
    <li><i class="fa fa-paper-plane"></i> Service posts<br></li>
    <li><i class="fa fa-comments"></i> Moderate Comments<br></li>
    </ul>
    </div>
    </div>
</div>
</div>
</div>