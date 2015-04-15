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
 				<p class="list-group-item-text">Social Media Profiles</p>
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
 					'options' => ['enctype'=>'multipart/form-data'],
 					'id' => 'registerForm',
 					'method'=>'POST',
 					'action'=>['site/register'],
 					'enableAjaxValidation' =>true,
					//'enableClientValidation'=>true,
 					'fieldConfig' => [
 					'template' =>  "<div class=\"form-group\">{input}</div><div class=\"form-error\">{error}</div>",
 					'inputOptions' => ['class'=>'form-control input-lg'],
 					],
 					]);
 					?> 					
 					<div class="row">
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<div class="form-group">
 								<?= $form->field($model, 'fname')->textInput(['maxlength'=>'50', 'placeholder'=>'First Name']);?>
 							</div>
 						</div>
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<div class="form-group">
 								<?= $form->field($model, 'lname')->textInput(['maxlength'=>'50', 'placeholder'=>'Last Name']);?>
 							</div>
 						</div>
 					</div>
 					<?= $form->field($model, 'display_name')->textInput(['maxlength'=>'50', 'placeholder'=>'Display Name']);?>
 					<?= $form->field($model, 'email')->input('email')->textInput(['placeholder'=>'Email']);?>

 					<h4>Upload a profile picture (Optional)</h4>
 					<div class="row">
 						<div class="col-xs-12 col-sm-12 col-md-12 bootstrap-file">
 							<?= $form->field($model, 'profilePic')->fileInput(['id'=>'input-2', 'class'=>'file', 'multiple'=>'true', 'data-show-upload'=>"false", 'data-show-caption'=>"true"]) ?>
 							<!-- <input id="input-2" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true"> -->
 						</div>
 					</div>
 					<div class="row">
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<?= $form->field($model, 'gender')->dropDownList([''=>'Select Gender', 'male'=>'Male', 'female'=>'Female', 'others'=>'Others']);?>
 						</div>
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<?= $form->field($model, 'dob')->input('date', ['min'=>'1930-01-01', 'max'=>date('Y-m-d', time()-(12*365*24*60*60))]);?>
 						</div>
 					</div>
 					<div class="row">
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<?= $form->field($model, 'password')->passwordInput(['maxlength'=>'50', 'placeholder'=>'Password']);?>
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
 							<?= $form->field($model, 'about')->textarea(['minlength'=>'20', 'maxlength'=>'200', 'placeholder'=>'Describe yourself (min 20 words)', 'rows'=>'6']);?>
 						</div>
 					</div>
 					<h4>Where do you live?</h4>
 					<div class="row">
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<?= Html::textInput('city', '', ['maxlength'=>'70', 'class'=>'form-control input-lg', 'placeholder'=>'City']);?>
 						</div>
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<?= Html::dropDownList('country', '', $countries, ['class'=>'form-control input-lg', 'placeholder'=>'City']);?>
 						</div>
 					</div><br>

 					<div class="row">
 						<div class="col-xs-4 col-sm-3 col-md-3">
 							<span class="button-checkbox">
 								<button type="button" class="btn" data-color="info" tabindex="7">
 									<i class="state-icon glyphicon glyphicon-unchecked"></i>
 									I Agree</button>
 									<?= Html::checkbox('tnc', 'true', ['class'=>'hidden tnc_register']);?>
 								</span>
 							</div>
 							<div class="col-xs-8 col-sm-9 col-md-9">
 								By ticking the <strong>I agree</strong> button, you agree to the <a href="#" data-toggle="modal" data-target="#t_and_c_m">Terms and Conditions</a> set out by this site, including our Cookie Use.
 							</div>
 						</div><br>
 						<button id="activate-step-3" class="btn btn-primary btn-lg">Next</button>
 					</div>
 				</div>
 			</div>
 		</div>
 		<div class="row setup-content" id="step-3">
 			<div class="col-xs-12 well"> 
 				<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">					
 					<h3 class="text-center"> Add your social profiles (Optional)!!</h3><br>				
 					<div class="row">
 						<div class="col-xs-12"> 
 							<div class="form-group">
 								<h4><i class="fa fa-facebook-official"></i> Facebook username: </h4>
 								<?= $form->field($model, 'facebook_url')->textInput(['value'=>'https://www.facebook.com/', 'placeholder'=>'Facebook Username', 'class'=>'social-input input-lg form-control']);?>
 							</div>
 						</div>
 					</div>
 					<div class="row">
 						<div class="col-xs-12"> 
 						<div class="form-group">
 							<h4><i class="fa fa-twitter"></i> Twitter username: </h4>
 							<?= $form->field($model, 'twitter_url')->textInput(['value'=>'https://www.twitter.com/', 'placeholder'=>'Twitter Username', 'class'=>'social-input input-lg form-control']);?>
 						</div>
 						</div>
 					</div>
 					<div class="row">
 						<div class="col-xs-12"> 
 						<div class="form-group">
 							<h4><i class="fa fa-google-plus-square"></i> Google+ Id: </h4>
 							<?= $form->field($model, 'google_url')->textInput(['value'=>'https://www.plus.google.com/', 'placeholder'=>'Google plus Username', 'class'=>'social-input input-lg form-control']);?>
 						</div>
 						</div>
 					</div>
 					<div class="row">
 						<div class="col-xs-12"> 
 						<div class="form-group">
 							<h4><i class="fa fa-facebook-official"></i> LinkdeIn Id: </h4>
 							<?= $form->field($model, 'linked_url')->textInput(['value'=>'https://www.linkedin.com/profile/view?id=', 'placeholder'=>'LinkedIn Username', 'class'=>'social-input input-lg form-control']);?>
 						</div>
 						</div>
 					</div>
 					<div class="row">
 						<div class="col-xs-8 col-sm-9 col-md-6">
 							<?= Html::submitButton('Register', ['class' => 'btn btn-primary btn-block btn-lg', 'name' => 'login-button']) ?>
 						</div>
 						<div class="col-xs-8 col-sm-9 col-md-6"><a href="#" class="btn btn-success btn-block btn-lg">Sign In</a></div>
 					</div>
 					<?php ActiveForm::end();?>
 				</div>
 			</div>
 		</div>
 	</div>
 	<hr class="colorgraph">
 </div>
</div>
<br><br>
<!-- Modal -->
<div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
			</div>
			<div class="modal-body">
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

