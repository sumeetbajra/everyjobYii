<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostServices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row" style="">

	<div class="col-md-12">
    <h3 class="montserrat">Place New Order</h3>
    <?= Html::encode($post->title); ?>
    <hr>
<div class="post-order-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'details')->textarea(['rows' => 6, 'placeholder'=>'Give additional description about your requirements']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Order' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a class="btn btn-primary" href="<?= Url::to(['post/view/'.$post->post_id.'/'.$post->slug]); ?>">Back</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>

   
</div>

</div>
