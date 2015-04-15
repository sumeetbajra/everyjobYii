<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostServices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-services-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['minlength'=>10, 'maxlength'=>80, 'placeholder'=>'Your service title (max 80 words)']) ?>

    <?= $form->field($model, 'description')->textarea(['minlength'=>10, 'maxlength'=>200, 'rows' => 6, 'placeholder'=>'Describe your post in maximum 200 words', 'id'=>'post-desc']) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categories)->label('Category*');?>

    <?= $form->field($model, 'price')->textInput(['maxlength' =>5, 'placeholder'=>'Name your price (Rs.)']) ?>

    <div class="bootstrap-file"><?= $form->field($model, 'image_url')->fileInput(['placeholder'=>'Upload a picture', 'id'=>'input-2', 'class'=>'file', 'multiple'=>'true', 'data-show-upload'=>"false", 'data-show-caption'=>"true"])->label('Upload a Promotional picture (800 &Chi; 500 recommended)'); ?></div>

    <?php //$form->field($model, 'expiry_date')->input('date', ['max'=>date('Y-m-d', time()), 'min'=>date('Y-m-d', (time())+20*86400)])->label('Expiry date (optional)'); ?>

    <?= $form->field($model, 'max_active_orders')->textInput(['maxlength'=>2, 'placeholder'=>'Maximum active orders the post can accept'])->label('Maximum number of active orders*') ?>

    <?= $form->field($model, 'max_delivery_days')->textInput(['maxlength' =>2, 'placeholder'=>'Maximum delivery days'])->label('Maximum delivery days*') ?>

    <?= $form->field($model, 'tags')->textInput(['placeholder'=>'Type tags separated by space', 'id'=>'myTags'])->label('Tags (Separated by space or tab)') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if(!$model->isNewRecord){ ?>
        <a class="btn btn-primary" href="<?= \Yii::$app->request->referrer; ?>">Back</a>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
