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
    <h3 class="montserrat">Notifications</h3>
    <hr>
<?php foreach($notifications as $notification){ ?>

<div class="notification">

<div class="row">
<img src="<?= Yii::getAlias('@web/images/users/') . Users::find()->where(['user_id'=>$notification->source])->one()->profilePic; ?>" class="pull-left" width="35">
<p>&nbsp;&nbsp;<?= $notification->notification; ?>&nbsp;<font size="1" color="#D0D0D0"><?php  print_r(time_agoo($notification->datetimestamp)); ?></font></p>
</div>
</a>
<hr>

    

</div>

<?php } ?>

   
</div>

</div>
