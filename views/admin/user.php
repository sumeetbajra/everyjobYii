<?php

use yii\helpers\Html;
use app\models\User;
use app\models\PostViews;
use app\models\PostServices;
use app\models\PostRatings;
use app\models\AcceptedOrders;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$ratings = new PostRatings;
$this->title = 'User details for '. $user->display_name;
$this->params['breadcrumbs'][] = 'User details';
$this->params['breadcrumbs'][] = $user->display_name;
?>
<?php if(Yii::$app->session->getFlash('message')){ ?>
	<div class="col-md-12 alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?= Yii::$app->session->getFlash('message'); ?></div>
		<?php } ?>
		<h4 class="montserrat" style="display:inline-block"><?= Html::encode($this->title) ?></h4> &nbsp;&nbsp;<a href="<?= Url::to(['/admin/viewusers'])?>"><i class="fa fa-arrow-circle-o-left"></i> Back</a>
		<hr>
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div class="well panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-sm-3 text-center">
								<img src="<?= \Yii::getAlias('@web/images/users/'.$user->profilePic); ?>" alt="" class="center-block img-circle img-thumbnail" width="150">
								<!-- <ul class="list-inline ratings text-center" title="Ratings"> -->
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
               <!--  <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
            </ul> -->
        </div>
        <!--/col--> 
        <div class="col-xs-12 col-sm-8">
        	<h2><?= $user->fname . ' ' . $user->lname;?></h2>
        	<p><strong>Member since: </strong> <?= $user->created_at;?> </p>
        	<p><strong>Address: </strong> <?= $user->address;?></p>
        	<p><strong>Display name: </strong> <?= $user->display_name;?></p>
        </div>
        <!--/col-->          
    </div>
    <!--/row-->
</div>
<!--/panel-body-->
</div>
<!--/panel-->
</div>
<!--/col--> 
</div>
<!--/row--> 

<ul class="nav nav-tabs">
	<li class="active"><a href="#posted" data-toggle="tab"><span class="fa fa-paper-plane"></span> 
		Posted Services</a></li>
		<li><a href="#bought" data-toggle="tab"><i class="fa fa-money"></i>
			Bought Services</a></li>
			<li><a href="#reviews" data-toggle="tab"><i class="fa fa-pencil"></i>
				Reviews</a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane fade in active" id="posted">
					<div class="list-group">
						<br>
						Services posted by the user<hr>
						<?php if(count($user->posts) > 0): ?>
						<div class="row text-center">
							<?php foreach ($user->posts as $post) { ?>
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
									<span style="position: relative; top: -12px">Sold:  <?= \Yii::$app->function->getSoldCount($post->post_id);?>&nbsp;&nbsp;<i class="fa fa-eye"></i> 
										<?= (PostViews::find()->where(['post_id'=>$post->post_id])->count() == 0 ? 0 : PostViews::find()->where(['post_id'=>$post->post_id])->one()->view_count);?> &nbsp;<i class="fa fa-thumbs-up"></i> <?= $ratings->postRating($post->post_id)['likes'];?> &nbsp;<i class="fa fa-thumbs-down"></i> <?= $ratings->postRating($post->post_id)['dislikes'];?></span>  <br>                  
										<?php if($post->featured == 1) : ?>
										<a href="<?= Url::to(['admin/addtofeatured/'.$post->post_id]); ?>" class="btn btn-danger">Remove featured</a>
									<?php else: ?>
									<a href="<?= Url::to(['admin/addtofeatured/'.$post->post_id]); ?>" class="btn btn-success">Add to featured</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			<?php else: ?>
			<i>No services posted yet</i>
		<?php endif; ?>
	</div>
</div>
<div class="tab-pane fade in" id="bought">
	<div class="list-group">
		<br>  Services bought by the user<hr>
		<?php $accepted = AcceptedOrders::find()->joinWith('posts')->where(['accepted_orders.user_id'=>$user->user_id])->all();
		if(count($accepted) > 0): ?>
		<div class="row text-center">
			<?php foreach ($accepted as $post) {  ?>
			<div class="col-md-3  hero-feature">
				<div class="thumbnail">
					<?php if($post->posts->featured == 1) : ?>
					<div class="ribbon-wrapper-green"><div class="ribbon-green">Featured</div></div>
				<?php endif; ?>
				<img src="<?= Yii::getAlias('@web'); ?>/images/services/<?= $post->posts->image_url; ?>" alt="Promotional image">
				<div class="caption" style="text-align:left">
					<h4 class="text-center">Price: <?= $post->posts->currency, ' ', Html::encode($post->posts->price); ?></h4>
					<p align="left" style="min-height: 40px"><?= substr(Html::encode($post->posts->title), 0, 70); ?></p><br>
					<span style="position: relative; top: -16px">by <b><a href="#"><?= User::findIdentity($post->posts->owner_id)->display_name; ?></b></a></span><br>
					<span style="position: relative; top: -12px">Sold:  <?= \Yii::$app->function->getSoldCount($post->posts->post_id);?>&nbsp;&nbsp;<i class="fa fa-eye"></i> 
						<?= (PostViews::find()->where(['post_id'=>$post->posts->post_id])->count() == 0 ? 0 : PostViews::find()->where(['post_id'=>$post->posts->post_id])->one()->view_count);?> &nbsp;<i class="fa fa-thumbs-up"></i> <?= $ratings->postRating($post->posts->post_id)['likes'];?> &nbsp;<i class="fa fa-thumbs-down"></i> <?= $ratings->postRating($post->posts->post_id)['dislikes'];?></span>  <br>                  
						<?php if($post->posts->featured == 1) : ?>
						<a href="<?= Url::to(['admin/addtofeatured/'.$post->post_id]); ?>" class="btn btn-danger">Remove featured</a>
					<?php else: ?>
					<a href="<?= Url::to(['admin/addtofeatured/'.$post->post_id]); ?>" class="btn btn-success">Add to featured</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<?php else: ?>
	<i>No services bought yet</i>
<?php endif; ?>
</div>
</div>
<div class="tab-pane fade in" id="reviews">
	<div class="list-group">
		<br>
		User Reviews<hr>
		<?php if(count($comments) > 0): ?>
		<?php foreach($comments as $comment){ ?>
		<div class="row">
			<div class="col-md-12">
				<img src="<?= \Yii::getAlias('@web/images/users/'.$comment->commentBy->profilePic); ?>" class="img-circle pull-left" style="margin-right:15px"width="80"><a href="<?= Url::to(['admin/user/'.$comment->commentBy->user_id]);?>" style="display:block; margin-bottom: -15px"><?= $comment->commentBy->display_name; ?></a><br>
				<?php for($i = 1; $i <= $comment->stars; $i++){ ?>
				<span class="glyphicon glyphicon-star"></span>
				<?php } ?> 
				<?php for($i = 1; $i <= 5 - $comment->stars; $i++){ ?>
				<span class="glyphicon glyphicon-star-empty"></span>
				<?php } ?> 
				<span class="pull-right"><?= \Yii::$app->function->getAgoTime($comment->datetimestamp); ?></span>
				<p><?= Html::encode($comment->comment);?></p>
			</div>
		</div>

		<hr>
		<?php } ?>
	<?php else: ?>
	<i>No user reviews yet</i>
<?php endif; ?>
</div>
</div>

</div>
