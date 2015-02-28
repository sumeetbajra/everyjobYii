<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostServices */

?>
<div class="row" style="">

	<div class="col-md-12">
    <h3 class="montserrat">Update Profile</h3>
    <hr>
<div class="post-services-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'about')->textarea(['rows' => 6, 'placeholder'=>'Describe yourself in maximum 200 words']) ?>

    <?= $form->field($model, 'dob')->input('date');?>

    <div class="bootstrap-file"><?= $form->field($model, 'profilePic')->fileInput(['id'=>'input-2', 'class'=>'file', 'multiple'=>'true', 'data-show-upload'=>"false", 'data-show-caption'=>"true"]) ?></div>
<div class="row">
   <div class="col-sm-6">
   	<?= Html::textInput('city', (!empty($model->address) ? explode(',', $model->address)[0]: ''), ['class'=>'form-control', 'placeholder'=>'City']);?>
   </div>
   <div class="col-sm-6">
   	<?php 
   	$country = explode(',', $model->address);
   	$country =  $country[1];
   	$country = (string) $country;
   	?>
   	
 	<?= Html::dropDownList('country', (!empty($model->address) ? array_search($country, $countries) : ''), $countries, ['class'=>'form-control', 'placeholder'=>'City']);?>
 </div>
</div><br>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if(!$model->isNewRecord){ ?>
        <a class="btn btn-primary" href="<?= Url::to(['user/profile']); ?>">Back</a>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

   
</div>

</div>
