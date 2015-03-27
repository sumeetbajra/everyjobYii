<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\PostViews;
use app\models\PostRatings;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Services posted by users';
$this->params['breadcrumbs'][] = $this->title;
$ratings = new PostRatings;
?>
<?php if(Yii::$app->session->getFlash('message')){ ?>
    <div class="col-md-12 alert alert-success alert-dismissible">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= Yii::$app->session->getFlash('message'); ?></div>
    <?php } ?>
<div class="post-category-index col-sm-9">

    <h4 class="montserrat"><?= Html::encode($this->title) ?></h4>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>    
    <div class="clearfix"></div>    
    <hr>
<div class="col-xs-12">
    <span class="pull-left">
    Sort accoring to: <select  id="sort-type">
        <option value="view">Most Viewed</option>
            <option value="likes">Most Liked</option>
            <option value="dislike">Most Disliked</option>
                <option value="sold">Most Sold</option>
    </select>
</span>
    <nav class="pull-right" style="margin-top:-19px">
  <ul class="pagination">
    <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <?php for ($i=1; $i <= $pages ; $i++) {  
        if(isset($_GET['sort'])){ 
           $str = mb_convert_encoding($_GET['sort'], 'UTF-8', 'UTF-8');
           $str = htmlentities($str, ENT_QUOTES, 'UTF-8'); ?>
           <li><a href="<?= Url::to(['admin/posts?sort='.$str.'&page='.$i]);?>"><?= $i; ?></a></li>    
        <?php }else{ ?>
            <li><a href="<?= Url::to(['admin/posts?page='.$i]);?>"><?= $i; ?></a></li>    
        <?php }
            
    } ?>
    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
<div class="clear-fix"></div>
</div>
<br><br>
    <div class="row text-center">

             <?php foreach ($posts as $post) { ?>
             <div class="col-md-4  hero-feature">
                <div class="thumbnail">
                    <?php if($post->featured == 1) : ?>
                    <div class="ribbon-wrapper-green"><div class="ribbon-green">Featured</div></div>
                <?php endif; ?>
                <img src="<?= Yii::getAlias('@web'); ?>/images/services/<?= $post->image_url; ?>" alt="Promotional image">
                <div class="caption" style="text-align:left">
                    <h4 class="text-center">Price: <?= $post->currency, ' ', Html::encode($post->price); ?></h4>
                    <p align="left" style="min-height: 40px"><?= substr(Html::encode($post->title), 0, 70); ?></p><br>
                    <span style="position: relative; top: -16px">by <b><a href="#"><?= User::findIdentity($post->owner_id)->display_name; ?></b></a></span><br>
                    <span style="position: relative; top: -12px">Sold:  <?= \Yii::$app->function->getSoldCount($post->post_id);?>&nbsp;&nbsp;<i class="fa fa-eye"></i> <?= (PostViews::find()->where(['post_id'=>$post->post_id])->count() == 0 ? 0 : PostViews::find()->where(['post_id'=>$post->post_id])->one()->view_count);?> &nbsp;<i class="fa fa-thumbs-up"></i> <?= $ratings->postRating($post->post_id)['likes'];?> &nbsp;<i class="fa fa-thumbs-down"></i> <?= $ratings->postRating($post->post_id)['dislikes'];?></span>                    
                    <?php $form = ActiveForm::begin([
                        'method'=>'POST',
                        'action' => ['post/update'],
                        ]);
                        ?>
                        <input type="hidden" name="post_id" value="<?= $post->post_id; ?>">
                        <a href="#" class="btn btn-primary">Delete</a> 
                        <?php if($post->featured == 1) : ?>
                  <a href="<?= Url::to(['admin/addtofeatured/'.$post->post_id]); ?>" class="btn btn-danger">Remove featured</a>
                <?php else: ?>
                        <a href="<?= Url::to(['admin/addtofeatured/'.$post->post_id]); ?>" class="btn btn-success">Add to featured</a>
                    <?php endif; ?>
                        <?php ActiveForm::end() ?>                        
                    </div>
                </div>
            </div>

            <?php  } ?>
        </div>
 <nav class="pull-right" style="margin-top:-19px">
  <ul class="pagination">
    <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
     <?php for ($i=1; $i <= $pages ; $i++) {  
        if(isset($_GET['sort'])){ 
           $str = mb_convert_encoding($_GET['sort'], 'UTF-8', 'UTF-8');
           $str = htmlentities($str, ENT_QUOTES, 'UTF-8'); ?>
           <li><a href="<?= Url::to(['admin/posts?sort='.$str.'&page='.$i]);?>"><?= $i; ?></a></li>    
        <?php }else{ ?>
            <li><a href="<?= Url::to(['admin/posts?page='.$i]);?>"><?= $i; ?></a></li>    
        <?php }
            
    } ?>
    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
</div>
<div class="col-sm-3">
<div class="panel panel-info">
  <div class="panel-heading">Quick links</div>
  <div class="panel-body">
  <ul class="nav nav-pills  nav-stacked quick-links">
  <li>
    <a href="<?= Url::to(['/admin'])?>"><i class="fa fa-th"></i>Dashboard</a></li>
    <li><a href="<?= Url::to(['category/index'])?>"><i class="fa fa-th-list"></i>Categories</a></li>
    <li><a href="<?= Url::to(['category/create'])?>"><i class="fa fa-plus"></i>Add category</a></li>
    </ul>
    </div>
    </div>
</div>
