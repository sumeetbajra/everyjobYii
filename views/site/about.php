<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
#about{
	min-height: 100%;
	height: 100%;
}

#about-background{
	min-height: 100%;
	height: auto;
	position: relative;
	top: -40px;
}

#about-text{
	position: relative;
	padding-right: 100px;
}


</style>
<div id="about" class="row">
	<div id="about-background" class="col-sm-4">
<img src="<?= \Yii::getAlias('@web/images/about.jpg');?>" class="img-responsive">
	</div>
	<div class="col-sm-8" id ="about-text">
		<h1><?= Html::encode($this->title); ?></h1><hr>
    
    <h3>Sed sollicitudin eu odio sed commodo</h3>
       <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sollicitudin eu odio sed commodo. Vivamus imperdiet arcu non vestibulum auctor. Nam commodo elit porttitor ante molestie, eu tincidunt leo tempus. Quisque dapibus sit amet orci ut vehicula. Vestibulum ornare posuere efficitur. Etiam non neque ut massa euismod eleifend. Nunc non porttitor est, eget interdum nisl. Vestibulum eu tellus eleifend, volutpat libero vel, venenatis eros. Integer congue a velit dictum lobortis. Ut laoreet risus tincidunt nibh tempor ultricies. Nullam dictum ut mi a vehicula.</p>

<h3>Praesent vitae elit ut enim</h3>
<p>Pellentesque id tempor metus, eu dignissim ex. Vivamus vestibulum eros non sem iaculis, non condimentum turpis fringilla. Praesent vitae elit ut enim tincidunt ultricies. Maecenas eu lobortis neque, et tincidunt enim. Fusce facilisis id ligula dignissim porttitor. Duis metus lectus, hendrerit ut finibus vel, auctor in ex. Mauris egestas arcu vel nibh vulputate pulvinar. Nullam maximus hendrerit nibh, rhoncus cursus elit venenatis quis. Duis non pharetra turpis. Nulla interdum blandit dolor vitae dignissim. Aliquam bibendum augue ut porttitor elementum. Fusce nibh nibh, eleifend sit amet dignissim sit amet, venenatis eget arcu. Nunc non egestas leo. Fusce in mauris vel ipsum pretium convallis at sit amet orci. Morbi eget pharetra arcu. Maecenas sodales nunc elit, ac scelerisque purus condimentum eu.</p>

<h3>Pulvinar felis mi, aliquet aucto</h3>
<p>Phasellus lacinia eget quam non semper. Curabitur at lectus justo. Sed varius odio non ante viverra sagittis. Duis eget elit mollis, dapibus arcu et, convallis ipsum. Integer feugiat quis dolor vitae viverra. Duis pharetra dui quis purus venenatis, ac iaculis neque maximus. Nunc augue mi, tincidunt ac pretium eget, consequat vel diam. Vestibulum quis euismod nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque tempus consectetur nunc, at aliquet sapien aliquet in. Ut imperdiet maximus magna eget rhoncus. Nullam non rhoncus mi. Curabitur et justo sed nisi cursus dignissim.</p>

<h3>Praesent vitae elit ut enim</h3>
<p>Curabitur sed aliquam ante, et vulputate lectus. Ut pulvinar felis mi, aliquet auctor turpis volutpat a. Phasellus aliquam ligula a purus tristique cursus eget sit amet nulla. Nam commodo porttitor tristique. Nam venenatis a dolor at fringilla. Quisque venenatis vehicula nunc vitae facilisis. Mauris non sem id dolor pretium porttitor ut et ligula. Sed volutpat rutrum rhoncus. Nullam nisl nisl, fermentum at lorem eget, lobortis laoreet metus. Phasellus vitae arcu sed risus egestas interdum vitae nec ligula. Phasellus luctus purus in ultrices vestibulum.</p>
</div>
<div class="clear-fix"></div>
</div>
