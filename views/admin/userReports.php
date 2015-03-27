<?php

use yii\helpers\Html;
use app\models\Users;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All the reports submitted by users';
$this->params['breadcrumbs'][] = 'User reports';
?>
<?php if(Yii::$app->session->getFlash('message')){ ?>
    <div class="col-md-12 alert alert-success alert-dismissible">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= Yii::$app->session->getFlash('message'); ?></div>
    <?php } ?>
    <?php if(Yii::$app->session->getFlash('error')){ ?>
    <div class="col-md-12 alert alert-danger alert-dismissible">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= Yii::$app->session->getFlash('error'); ?></div>
    <?php } ?>
<h4 class="montserrat" style="display:inline-block"><?= Html::encode($this->title) ?></h4> &nbsp;&nbsp;<a href="<?= Url::to(['/admin'])?>"><i class="fa fa-arrow-circle-o-left"></i> Back to dashboard</a>
<hr>

<table id="myTable" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>User</th>
                <th>Report for</th>
                <th>Date</th>
                <th>Reported by</th>
                <th>Action</th>
            </tr>
        </thead>
 
        <tfoot>
          <tr>
                <th>Id</th>
                <th>User</th>
                <th>Reported for</th>
                <th>Date</th>
                <th>Reported by</th>
                <th>Action</th>
            </tr>
        </tfoot>
 
        <tbody>
          <?php foreach ($reports as $report) { ?>
          	<tr>
          	<td><?= $report->report_id; ?></td>
          	<td><a href="<?= Url::to(['/admin/user/'.$report->user->display_name]); ?>" title="Go to profile"><?= $report->user->display_name; ?></a></td>
          	<td><?= $report->report; ?></td>
          	<td><?= date('M d, Y', strtotime($report->datetimestamp)); ?></td>
            <td><a href="<?= Url::to(['/admin/user/'.Users::findOne($report->reported_by)->display_name]); ?>" title="Go to profile"><?= Users::findOne($report->reported_by)->display_name; ?></a></td>
          	<td><a href="<?= Url::to(['/admin/closereport/'.$report->report_id]);?>" class="btn btn-danger btn-sm">Close</a>
          	<a href="#" class="btn btn-primary btn-sm admin-msg-btn" id="<?= $report->user_id;?>" title="Send message" data-target="#message" data-toggle="modal"><i class="fa fa-envelope"></i></a>
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
   