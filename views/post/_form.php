<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostServices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-services-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'placeholder'=>'Describe your post in maximum 200 words']) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categories)->label('Category');?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => 10, 'placeholder'=>'Name your price (Rs.)']) ?>

    <div class="bootstrap-file"><?= $form->field($model, 'image_url')->fileInput(['placeholder'=>'Upload a picture', 'id'=>'input-2', 'class'=>'file', 'multiple'=>'true', 'data-show-upload'=>"false", 'data-show-caption'=>"true"]) ?></div>

    <?= $form->field($model, 'expiry_date')->input('date')->label('Expiry date (optional)'); ?>

    <?= $form->field($model, 'max_active_orders')->textInput(['placeholder'=>'Maximum active orders the post can accept'])->label('Maximum number of active orders') ?>

    <?= $form->field($model, 'max_delivery_days')->textInput(['placeholder'=>'Maximum delivery days'])->label('Maximum delivery days') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
