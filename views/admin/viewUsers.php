<?php

use yii\helpers\Html;
use app\models\User;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All the registered users';
$this->params['breadcrumbs'][] = 'Registered Users';
?>
<?php if(Yii::$app->session->getFlash('message')){ ?>
    <div class="col-md-12 alert alert-success alert-dismissible">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= Yii::$app->session->getFlash('message'); ?></div>
    <?php } ?>
<h4 class="montserrat" style="display:inline-block"><?= Html::encode($this->title) ?></h4> &nbsp;&nbsp;<a href="<?= Url::to(['/admin'])?>"><i class="fa fa-arrow-circle-o-left"></i> Back to dashboard</a>
<hr>

<table id="myTable" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Display Name</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Joined Date</th>
                <th>Service Posts</th>
                <th>Services Bought</th>
                <th>Action</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Id</th>
                <th>Display Name</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Joined Date</th>
                <th>Service Posts</th>
                <th>Services Bought</th>
                <th>Action</th>
            </tr>
        </tfoot>
 
        <tbody>
          <?php foreach ($users as $user) { ?>
          	<tr>
          	<td><?= $user->user_id; ?></td>
          	<td><?= $user->display_name; ?></td>
          	<td><?= $user->fname; ?></td>
          	<td><?= $user->lname; ?></td>
          	<td><?= date('M d, Y', strtotime($user->created_at)); ?></td>
          	<td style="padding-left:25px"><a href="<?= Url::to(['/admin/user/'.$user->user_id.'#posted']); ?>" class="table-link"><?= \Yii::$app->function->getPostedServices($user->user_id); ?></a></td>
          	<td style="padding-left:25px"><a href="<?= Url::to(['/admin/user/'.$user->user_id.'#bought']); ?>" class="table-link"><?= \Yii::$app->function->getBoughtServices($user->user_id); ?></a></td>
          	<td><a onclick="bootbox.confirm('Are you sure?', function(result){if(result){window.location='<?= Url::to(['user/deactivate/'.$user->user_id]);?>'}});" href="#" class="btn btn-danger btn-sm deactivateUser">Deactivate</a>&nbsp;<a href="<?= Url::to(['/admin/user/'.$user->user_id]); ?>" class="btn btn-primary btn-sm" title="Details"><i class="fa fa-info-circle"></i></a>
          	<a href="#" class="btn btn-primary btn-sm admin-msg-btn" id="<?= $user->user_id;?>" title="Send message" data-target="#message" data-toggle="modal">
              <i class="fa fa-envelope"></i></a>
          	</a>
          	</td>
          	</tr>
          <?php } ?>
        </tbody>
    </table>
   
    <div class="modal fade" id="message" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="width:40%; top:30px">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">Send message to User</h4>
                            </div>
                            <div class="modal-body">
                               <?php $form = ActiveForm::begin(['options'=>['id'=>'admin-msg-form']]);?>
                <?= $form->field($model, 'subject')->textInput(['placeholder'=>'Subject']);?>
                <?= $form->field($model, 'message')->textarea(['placeholder'=>'Type your message', 'rows'=>'5']);?>
                <?= Html::activeHiddenInput($model, 'to_user', ['value'=>'']); ?>
                         </div>
                           <div class="modal-footer">
                             <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'message-button', 'id'=>'admin-message']) ?>
                             <?= Html::button('Close', ['class' => 'btn btn-danger', 'data-dismiss'=>'modal']) ?>
                             <?php ActiveForm::end(); ?>
                         </div>
                     </div><!-- /.modal-content -->
                 </div><!-- /.modal-dialog -->
             </div><!-- /.modal -->