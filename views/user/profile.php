<?php
use yii\helpers\Url;
use yii\grid\GridView;
?>
<?php if(!empty(Yii::$app->session->getFlash('message'))){ ?>
<div class="col-md-12 alert alert-info"><?= Yii::$app->session->getFlash('message'); ?></div>
<?php } ?>
<div class="row" style="margin-top:35px">
    <div class="col-md-3">
    	<div class="profile-side-menu">
    		<div class="profile-pic">
    		<img src="<?= Yii::getAlias('@web');?> /images/default.jpg" class="img-circle img-responsive" width="100">
    		<h4 class="montserrat"><?= $user->display_name; ?></h4>
    	</div>
       <ul >
        <li><a href="<?= Url::to(['post/create']) ?>"><i class="fa fa-plus"></i> Create a post</a></li>
        <li><a><i class="fa fa-tasks"></i> Active tasks</a></li>
        <li><a><i class="fa fa-envelope"></i> Messeges (0)</a></li>
        <li><a><i class="fa fa-globe"></i> Notifications (0)</a></li>
        <li><a><i class="fa fa-check-square-o"></i> Ordered services</a></li>
        <li><a><i class="fa fa-user"></i> View profile</a></li>
        <li><a><i class="fa fa-cogs"></i> Profile Settings</a></li>
       </ul>
    </div>
</div>
    <div class="col-md-9 well">
    	<h3 class="montserrat"><?= $user->display_name;?></h3> (member since <?= date('F Y', strtotime($user->created_at));?>)<hr>
    	<div class="row">
    		<div class="col-md-3 col-sm-6 text-center">
    			<h2>12</h2>
    			created posts
    		</div>
    		<div class="col-md-3 col-sm-6 text-center">
    			<h2>7</h2>
    			created posts
    		</div>
    		<div class="col-md-3 col-sm-6 text-center">
    			<h2>12</h2>
    			created posts
    		</div>
    		<div class="col-md-3 col-sm-6 text-center">
    			<h2>12</h2>
    			created posts
    		</div>
    	</div><br><hr>
    	<h4>About</h4>
    	<p><?= $user->about; ?></p>
    	<p><i class="fa fa-globe"></i> <?= $user->address;?></p>
    	<p><i class="fa fa-birthday-cake"></i> <?= $user->dob; ?></p>
    	<hr>
    	<h4>Created posts</h4>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'post_id',
            'description:ntext',
            //'category_id',
           // 'owner_id',
            'price',
            // 'image_url:url',
            // 'expiry_date',
            // 'datetimestamp',
            // 'max_active_orders',
            // 'max_delivery_days',
            // 'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>