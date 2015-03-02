<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Users;
use app\models\RejectedOrder;

/* @var $this yii\web\View */
/* @var $model app\models\PostServices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row" style="">

    <?php if(!empty(Yii::$app->session->getFlash('message'))){ ?>
    <div class="col-md-12 alert alert-info"><?= Yii::$app->session->getFlash('message'); ?></div>
    <?php } ?>

    <div class="col-md-12">
        <?php if($number == 0) :?>
        <h3 class="montserrat">You have no pending orders</h3>
        <?php else: ?>
        <h3 class="montserrat">You have received new order(s)</h3>
        <?php endif; ?>
<?= $model->title; ?>
<hr>

<?php foreach($orders as $order){
    $reject = new RejectedOrder;
    ?>
    <div class="post-order">

        <div class="row">
            <div class="col-sm-1"><img src ="<?= Yii::getAlias('@web/images/users/'.Users::find()->where(['user_id'=>$order->user_id])->one()->profilePic); ?>" class="img-responsive"></div>
            <div class="col-sm-11" style="padding-left: 0px"><div class="montserrat"><?= Users::find()->where(['user_id'=>$order->user_id])->one()->display_name; ?></div>
            <font size="1" color="#AAA1A1" style="margin-bottom: -15px; display:block"><?= date('F d Y', strtotime($order->datetimestamp)); ?></font><br>
            <p><?= $order->details; ?></p>
        </div>
    </div><br>

    <?php $form = ActiveForm::begin(['action'=>['post/acceptorder']]); ?>
    <?= Html::hiddenInput('order_id', $order->order_id);?>
    <button type="submit" href="#" class="btn btn-primary btn-success" id="confirmOrder"><i class="fa fa-check"></i> Accept</button> 
    <a href="" class="btn btn-primary btn-danger reject-order-btn"><i class="fa fa-times"></i> Reject</a>
        <?php ActiveForm::end(); ?>

<hr>

<div class="reject-form hidden-form">
    <h4 class="montserrat">Let them know why their order got rejected</h4>
<?php $form = ActiveForm::begin(['action'=>Url::to(['post/processorder'])]); ?>
    <?= $form->field($reject, 'reason')->textarea(['rows' => 6, 'placeholder'=>'Make it concise and clear']) ?>
    <?= Html::activeHiddenInput($reject, 'order_id', ['value'=>$order->order_id]); ?>
    <?= Html::hiddenInput('post_id', $order->post_id); ?>
    <?= Html::hiddenInput('user_id', $order->user_id); ?>
    <?= Html::submitButton('Submit',  ['class' =>'btn btn-primary pull-right']) ?>
</div> 

</div>
<?php ActiveForm::end(); ?>
<?php } ?>

</div>

</div>

<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Are you sure?</h4>
            </div>
            <div class="modal-body">
               You won't be able to revert this action.
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" data-dismiss="modal">Confirm</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

