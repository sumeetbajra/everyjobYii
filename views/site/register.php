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
 </style>




<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		<?php $form = ActiveForm::begin([	
 					'id' => 'registerForm',
 					'method'=>'POST',
 					'action'=>['site/register'],
					'enableAjaxValidation'=>true,
					//'enableClientValidation'=>false,
 					'fieldConfig' => [
 					'template' =>  "<div class=\"form-group\">{input}</div><div class=\"alert alert-danger\">{error}</div>",
 					'inputOptions' => ['class'=>'form-control input-lg'],
 					],
 					]);
		echo "<pre>"
		print_r($form);
		exit;
 					?>
			<h2>Please Sign Up <small>It's free and always will be.</small></h2>
			
 								<?= $form->field($model, 'fname')->textInput(['placeholder'=>'First Name']);?>
 						
 								<?= $form->field($model, 'lname')->textInput(['placeholder'=>'Last Name']);?>
 							
 					<?= $form->field($model, 'display_name')->textInput(['placeholder'=>'Display Name']);?>
 					<?= $form->field($model, 'email')->input('email')->textInput(['placeholder'=>'Email']);?>

 					
 				
 							<?= $form->field($model, 'gender')->dropDownList([''=>'Select Gender', 'male'=>'Male', 'female'=>'Female', 'others'=>'Others']);?>
 							<?= $form->field($model, 'dob')->input('date');?>
 							<?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password']);?>
 								<?= Html::passwordInput('re_password', '', ['class'=>'form-control input-lg', 'placeholder'=>'Confirm Password']);?>
 					<div class="row">
 						<div class="col-xs-4 col-sm-3 col-md-3">
 							<span class="button-checkbox">
 								<button type="button" class="btn" data-color="info" tabindex="7">
 									<i class="state-icon glyphicon glyphicon-unchecked"></i>
 									I Agree</button>
 									<?= Html::checkbox('tnc', 'true', ['class'=>'hidden']);?>
 								</span>
 							</div>
 							<div class="col-xs-8 col-sm-9 col-md-9">
 								By clicking <strong class="label label-primary">Register</strong>, you agree to the <a href="#" data-toggle="modal" data-target="#t_and_c_m">Terms and Conditions</a> set out by this site, including our Cookie Use.
 							</div>
 							<div class="row">
 					<div class="col-xs-12 col-md-6">
 						<?= Html::submitButton('Register', ['class' => 'btn btn-primary btn-block btn-lg', 'name' => 'login-button']) ?>
 					</div>
 					<div class="col-xs-12 col-md-6"><a href="#" class="btn btn-success btn-block btn-lg">Sign In</a></div>
 				</div>
 				<?php ActiveForm::end();?>
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

