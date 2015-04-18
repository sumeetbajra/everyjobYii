<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-category-form">
	<?php if(\Yii::$app->session->getFlash('error')): ?>
		<div class="alert alert-danger"><?= \Yii::$app->session->getFlash('error');?></div>
	<?php endif; ?>

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'category_name')->textInput() ?>
 					<div class="row">
 						<div class="col-xs-12 col-sm-12 col-md-12 bootstrap-file">
 							<?= $form->field($model, 'category_pic')->fileInput(['accept'=>'accept="image/gif, image/bmp, image/jpg, image/png, image/jpeg"']); ?>
 							<?php //= $form->field($model, 'category_pic')->fileInput(['id'=>'input-2', 'class'=>'file', 'multiple'=>'true', 'data-show-upload'=>"false", 'data-show-caption'=>"true"]); ?>
 							<!-- <input id="input-2" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true"> -->
 						</div>
 					</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
