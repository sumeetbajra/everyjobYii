<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Users;

/* @var $this yii\web\View */
/* @var $model app\models\PostServices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row" style="">

	<div class="col-md-12">
    <h3 class="montserrat">You have received new order(s)</h3>
    <?= $model->title; ?>
    <hr>
<?php foreach($orders as $order){?>

<div class="post-order">

<div class="row">
<div class="col-sm-1"><img src ="<?= Yii::getAlias('@web/images/users/'.Users::find()->where(['user_id'=>$order->user_id])->one()->profilePic); ?>" class="img-responsive"></div>
<div class="col-sm-11" style="padding-left: 0px"><div class="montserrat"><?= Users::find()->where(['user_id'=>$order->user_id])->one()->display_name; ?></div>
<font size="1" color="#AAA1A1" style="margin-bottom: -15px; display:block"><?= date('F d Y', strtotime($order->datetimestamp)); ?></font><br>
<p><?= $order->details; ?></p>
</div>
</div><br>
<a href="" class="btn btn-primary btn-success"><i class="fa fa-check"></i> Accept</a> <a href="" class="btn btn-primary btn-danger"><i class="fa fa-times"></i> Reject</a>
<hr>

    

</div>

<?php } ?>

   
</div>

</div>
