<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Enter new password';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'fieldConfig' => [
            'template' => "<div class=\"form-group\">{input}</div>",
            'inputOptions' => ['class' => 'form-control input-lg'],
        ],
    ]); ?>

            <fieldset>
                <h2>Reset password</h2>
                   
                   <?=  $form->errorSummary($user, ['class'=>'alert alert-warning']); ?>
                <hr class="colorgraph">
              

        <?= $form->field($user, 'password')->passwordInput(['value'=>'', 'placeholder'=>'Type your new password']) ?>
                <?= $form->field($user, 'repassword')->passwordInput(['value'=>'', 'placeholder'=>'Re enter your password']) ?>
              

                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                           <?= Html::submitButton('Reset', ['class' => 'btn btn-lg btn-success btn-block', 'name' => 'login-button']) ?>
                    </div>
                </div>
            </fieldset>
        <?php ActiveForm::end(); ?>
    </div>   

    </div>

