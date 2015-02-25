<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
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
                <h2>Please Sign In</h2>
                   
                   <?=  $form->errorSummary($model, ['class'=>'alert alert-warning']); ?>
                <hr class="colorgraph">
              

        <?= $form->field($model, 'email')->input('email');?>
                <?= $form->field($model, 'password')->passwordInput() ?>
              
<span class="button-checkbox">
                    <button type="button" class="btn btn-default" data-color="info"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Remember Me</button>
                                <?= $form->field($model, 'rememberMe', [
        'template' => "<span class=\"button-checkbox\">{input}</div>",
        'options' => ['class'=>'hidden', 'checked'=>'checked' ], 
        ])->checkbox() ?>

                  

        
                    <a href="" class="btn btn-link pull-right">Forgot Password?</a>
                </span>
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                           <?= Html::submitButton('Login', ['class' => 'btn btn-lg btn-success btn-block', 'name' => 'login-button']) ?>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <a href="" class="btn btn-lg btn-primary btn-block">Register</a>
                    </div>
                </div>
            </fieldset>
        <?php ActiveForm::end(); ?>
    </div>   

    </div>

