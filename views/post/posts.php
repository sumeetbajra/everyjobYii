<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\PostViews;
use app\models\PostRatings;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$ratings = new PostRatings;
?>

<h3 class="montserrat">All the posts</h3><hr><br>
<input type="hidden" value="<?= ceil(count($posts) / 8)?>" name="totalPages">
 <input type="hidden" value="<?= $sort?>" name="sort">
 <input type="hidden" value="<?= $keywords?>" name="keywords">


 <div class="row">
    <span class="col-sm-3">
    <div style="font-size:15px; margin-bottom:7px">Sort accoring to:</div> <select  id="sort-type" class="form-control">
        <option value="view">Most Viewed</option>
            <option value="likes">Most Liked</option>
            <option value="dislike">Most Disliked</option>
                <option value="sold">Most Sold</option>
    </select>
</span>
<span class="col-sm-6">
	<div style="font-size:15px; margin-bottom:7px">Search via keywords:</div>
	<input class="form-control" placeholder="What are looking to get done?" id="search-input" value="<?= $result = str_replace('+', ' ', $keywords);?>"></input>
	</span>
<span class="col-sm-3">
</span>
<div class="clear-fix"></div>
</div>
<?php if(!empty($keywords)): ?>
<br>
<h4><?= count($posts)?> result(s) found for "<?= $result; ?>"</h4><hr>
<?php endif; ?>
<div class="page-selection pull-left"></div>
<div class="clear-fix"></div>
<br>
    <div class="row text-center" id="content">

             <?php foreach ($posts as $post) { ?>
             <div class="col-md-3  hero-feature">
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
                    <p><a href="<?= Url::to(['post/view/'.$post->post_id.'/'.$post->slug]); ?>" class="btn btn-primary">More Info</a></p>
                    </div>
                </div>
            </div>

            <?php  } ?>
        </div>

<div class="page-selection pull-left"></div>
<div class="clear-fix"></div>
</div>
