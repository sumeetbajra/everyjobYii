 <?php 
 use yii\helpers\Html;
 use yii\bootstrap\ActiveForm;
 ?>

  <style>
 .alert{
 	display: none;
 }

 .has-error .alert{
 	display: block;
 }

 .form-error{
 	text-align: left;
 }

 </style>
 <div class="row form-group">
 	<div class="col-xs-12">
 		<h2>Please Sign Up <small>It's free and always will be.</small></h2>
 		<hr class="colorgraph">
 		<ul class="nav nav-pills nav-justified thumbnail setup-panel">
 			<li class="active"><a href="#step-1">
 				<h4 class="list-group-item-heading">Step 1</h4>
 				<p class="list-group-item-text">Basic Details</p>
 			</a></li>
 			<li class="disabled"><a href="#step-2">
 				<h4 class="list-group-item-heading">Step 2</h4>
 				<p class="list-group-item-text">Other Information</p>
 			</a></li>
 			<li class="disabled"><a href="#step-3">
 				<h4 class="list-group-item-heading">Step 3</h4>
 				<p class="list-group-item-text">Third step description</p>
 			</a></li>
 		</ul>
 	</div>
 </div>
 <div class="row setup-content" id="step-1">
 	<div class="col-xs-12">
 		<div class="col-md-12 well text-center">
 			<h3>Please fill out the following</h3><hr>
 			<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

		<?php $form = ActiveForm::begin([	
 					'id' => 'registerForm',
 					'options' => ['enctype'=>'multipart/form-data'],
 					'method'=>'POST',
 					'action'=>['site/register'],
					'enableAjaxValidation'=>true,
					//'enableClientValidation'=>false,
 					'fieldConfig' => [
 					'template' =>  "<div class=\"form-group\">{input}</div><div class=\"alert alert-danger\">{error}</div>",
 					'inputOptions' => ['class'=>'form-control input-lg'],
 					],
 					]);

 					?>
 					<div class="row">
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<div class="form-group">

 								<?= $form->field($model, 'fname')->textInput(['placeholder'=>'First Name']);?>
 									<?= $form->field($model, 'fname')->textInput(['placeholder'=>'First Name']);?>
 							</div>
 						</div>
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<div class="form-group">
 							
 								<?= $form->field($model, 'lname')->textInput(['placeholder'=>'Last Name']);?>
 								</div>
 						</div>
 					</div>
 						
 					<?= $form->field($model, 'display_name')->textInput(['placeholder'=>'Display Name']);?>
 					<?= $form->field($model, 'email')->input('email')->textInput(['placeholder'=>'Email']);?>

 					
 					<div class="row">
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<?= $form->field($model, 'gender')->dropDownList([''=>'Select Gender', 'male'=>'Male', 'female'=>'Female', 'others'=>'Others']);?>
 						
 						</div>
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<?= $form->field($model, 'dob')->input('date');?>
 						</div>
 					</div>
 					<div class="row">
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password']);?>
 							</div>
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<div class="form-group">
 						
 								<?= Html::passwordInput('re_password', '', ['class'=>'form-control input-lg', 'placeholder'=>'Confirm Password']);?>
 						</div>
 						</div>
 					</div>
 					<div class="row">
 						<button id="activate-step-2" class="btn btn-primary btn-lg pull-left" style="margin-left: 15px">Proceed</button>
 						<button class="btn btn-primary btn-lg pull-left" style="margin-left: 10px">Cancel</button>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>

 	<div class="row setup-content" id="step-2">
 		<div class="col-xs-12  well">
 			<div class="col-md-12 ">
 				<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
 					<h3 class="text-center"> Great!! Now few more</h3><br>
 					<h4>Write about yourself</h4>
 					<div class="row">
 						<div class="col-xs-12 col-sm-12 col-md-12">
 							<?= $form->field($model, 'about')->textarea(['placeholder'=>'Describe yourself (min 20 words)', 'rows'=>'6']);?>
 						
 							<?= Html::textInput('city', '', ['class'=>'form-control input-lg', 'placeholder'=>'City']);?>
 						
 							<?= Html::dropDownList('country', '', $countries, ['class'=>'form-control input-lg', 'placeholder'=>'City']);?>
 					
 						<div class="col-xs-12 col-sm-12 col-md-12 bootstrap-file">
 							<?= $form->field($model, 'profilePic')->fileInput(['id'=>'input-2', 'class'=>'file', 'multiple'=>'true', 'data-show-upload'=>"false", 'data-show-caption'=>"true"]) ?>
 							<!-- <input id="input-2" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true"> -->
 						</div>
 					
 									<?= Html::checkbox('tnc', 'true', ['class'=>'hidden tnc_register']);?>
 			
 								<?= Html::submitButton('Register', ['class' => 'btn btn-primary btn-block btn-lg', 'name' => 'login-button']) ?>
 							
 					
		

		<?php ActiveForm::end();?>