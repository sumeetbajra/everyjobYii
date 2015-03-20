<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Users;
use app\models\PostServices;

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
        <h3 class="montserrat">You have no rejected orders</h3>
        <?php else: ?>
        <h3 class="montserrat">Your rejected order(s)</h3>
        <?php endif; ?>
<hr>

<?php foreach($rejected as $reject){?>
    <div class="post-order">

        <div class="row">
            <h4 class="montserrat"><?= Html::encode(PostServices::findOne($reject->rejected->order_id)->title); ?></h4>
            <b>Owner: </b><a href ="<?= Url::to(['user/profile/'.Html::encode(Users::findOne($reject->user_id)->display_name])); ?>"><?= Html::encode(Users::findOne($reject->user_id)->display_name); ?></a><br>
            <b>Ordered date:</b> <?= date('F m, Y', strtotime($reject->datetimestamp));?><br>
            <b>Additional order info:</b> <?= Html::encode($reject->details);?><br>
            <b>Rejected date:</b> <?= date('F m, Y', strtotime($reject->rejected->datetimestamp));?><br>
            <b>Reason:</b> <?= Html::encode($reject->rejected->reason); ?>
        </div>
    </div><br>
<hr>
<?php } ?>




</div>

</div>
