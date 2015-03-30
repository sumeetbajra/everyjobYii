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

    <?php if(Yii::$app->session->getFlash('message')){ ?>
    <div class="col-md-12 alert alert-info"><?= Yii::$app->session->getFlash('message'); ?></div>
    <?php } ?>

    <div class="col-md-12">
        <div class="row">
        <?php if($number == 0) :?>
        <h3 class="montserrat">You have no rejected orders</h3>
        <?php else: ?>
        <h3 class="montserrat">Your rejected order(s)</h3>
        <?php endif; ?>
        <hr><br>
    </div>

<?php foreach($rejected as $reject){?>
    <div class="post-order">

        <div class="row">
            <table class="table table-responsive table-bordered table-condensed table-curved">
                <tr>
                    <td colspan="2"><h4 class="montserrat"><?= Html::encode(PostServices::findOne($reject->rejected->order_id)->title); ?></h4></td>
                </tr>
                <tr>
                    <td>
                        <b>Owner: </b>
                    </td>
                    <td>
                        <a href ="<?= Url::to(['user/profile/'.Html::encode(Users::findOne($reject->user_id)->display_name)]); ?>"><?= Html::encode(Users::findOne($reject->user_id)->display_name); ?></a>
                    </td>
                </tr>
                <tr>
                    <td>
                         <b>Ordered date:</b> 
                    </td>
                    <td>
                        <?= date('F m, Y', strtotime($reject->datetimestamp));?>
                    </td>
                </tr>
                <tr>
                    <td>
                          <b>Additional order info:</b> 
                    </td>
                    <td>
                        <?= Html::encode($reject->details);?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Rejected date:</b> 
                    </td>
                    <td>
                        <?= date('F m, Y', strtotime($reject->rejected->datetimestamp));?>
                    </td>
                </tr>
                <tr>
                    <td>
                         <b>Reason:</b> 
                    </td>
                    <td>
                        <?= Html::encode($reject->rejected->reason); ?>
                    </td>
                </tr>
            
           </table>
          
            
           
        </div>
    </div><br>
<hr>
<?php } ?>




</div>

</div>
