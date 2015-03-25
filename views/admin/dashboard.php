<?php
use yii\helpers\Url;
?>

<div class="row">
<div class="well">
Welcome admin!! You are in the backend of the website. Below are the facilities available to you</div>

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
    <div class="classWithPadding well text-center"><a href="<?= Url::to(['admin/posts']); ?>">
    <font size="8"><i class="fa fa-paper-plane"></i></font><br>
    Service posts</a>
    </div>
    </div>
    <div class="col-sm-3">
    <div class="classWithPadding well text-center"><a href="#">
    <font size="8"><i class="fa fa-money"></i></font><br>
    Cash withdrawal
</a>
    </div>
    </div>
    <div class="col-sm-3">
    <div class="classWithPadding well text-center"><a href="#">
    <font size="8"><i class="fa fa-flag"></i></font><br>
    User reports</a>
    </div>
    </div>
     <div class="col-sm-3">
    <div class="classWithPadding well text-center"><a href="#">
    <font size="8"><i class="fa fa-user"></i></font><br>
    Registered users</a>
    </div>
    </div>
     <div class="col-sm-3">
    <div class="classWithPadding well text-center"><a href="#">
    <font size="8"><i class="fa fa-file"></i></font><br>
    Manage Content</a>
    </div>
    </div>
  </div>
</div>
</div>
<div class="col-md-4">
<div class="panel panel-primary">
  <div class="panel-heading">Quick links</div>
  <div class="panel-body">
  <ul class="nav nav-pills  nav-stacked quick-links">
  <li>
    <a href="#"><i class="fa fa-user"></i>Admin details</a></li>
    <li><a href="#"><i class="fa fa-cog"></i>Profile settings</a></li>
    <li><a href="#"><i class="fa fa-eye"></i>View live site</a></li>
    </ul>
    </div>
    </div>
</div>
</div>
</div>