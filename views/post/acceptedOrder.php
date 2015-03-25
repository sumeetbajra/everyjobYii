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
        <h3 class="montserrat">You have no accepted orders</h3>
    <?php else: ?>
    <h3 class="montserrat">Your accepted order(s)</h3>
    Your orders are complete once you make the payments.
<?php endif; ?>
<hr>

<?php foreach($accepted as $accept){
    $post = PostServices::findOne($accept->post_id);
    ?>

    <?php
    //$url = 'http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency=NPR&ToCurrency=USD';
    //$xml = simpleXML_load_file($url,"SimpleXMLElement",LIBXML_NOCDATA);
    /*if($xml ===  FALSE)
    {
               //deal with error
    }
    else { */
        $rate = 100;
        $cost = PostServices::findOne($accept->post_id)->price;
        $price = round($cost * "$rate[0]", 2);
    //}
    ?>

    <div class="post-order">

        <table class="table table-bordered">
            <tr>
                <td>
                    <b>Title: </b>
                </td>
                <td>
                    <h4 class="montserrat"><?= $title = Html::encode($post->title); ?></h4>
                </td>
            </tr>

            <tr>
                <td>
                    <b>Owner: </b>
                </td>
                <td>
                    <a href ="<?= Url::to(['user/profile/'.Users::findOne($post->owner_id)->display_name]); ?>"><?= Html::encode(Users::findOne($post->owner_id)->display_name); ?></a>
                </td>
            </tr>

            <tr>
                <td>
                    <b>Requested date: </b>
                </td>
                <td>
                 <?= date('F d, Y', strtotime($accept->datetimestamp)); ?>
             </td>
         </tr>

         <tr>
            <td>
                <b>Accepted date: </b>
            </td>
            <td>
             <?= date('F d, Y', strtotime($accept->accepted->datetimestamp)); ?>
         </td>
     </tr>

     <tr>
        <td>
            <b>Price:</b>
        </td>
        <td>
            Rs. <?= Html::encode($cost); ?>
        </td>
    </tr>

    <tr>
        <td>
           <b>Maximum delivery days: </b>
       </td>
       <td>
          <?= $post->max_delivery_days; ?>
      </td>
  </tr>

  <tr>
    <td>
      <b>Choose payment option: </b>
  </td>
  <td>
     <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" style="float:left; margin-right: 30px" target="_new">
        <img src="<?= Yii::getAlias('@web/images/paypal.png');?>" style="display:block">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="return" value="https://3b21de01.ngrok.com/everyjobSite/web/user/dashboard">
        <input type="hidden" name="business" value="sumeetbazra@gmail.com">
        <input type="hidden" name="item_name" value="<?= Html::encode($title);?>">
        <input type="hidden" name="item_number" value="<?= $accept->post_id; ?>">
        <input type="hidden" name="amount" value="<?= Html::encode($price); ?>">
        <input type="hidden" name="notify_url" value="https://3b21de01.ngrok.com/everyjobSite/web/payment/paypalipn">
        <input type="hidden" name="cancel_return" value="https://3b21de01.ngrok.com/everyjobSite/web/user/dashboard">
        <input type="hidden" name="tax" value="0">
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="no_note" value="1">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="custom" value="<?= $accept->order_id; ?>">
        <input type="image" name="submit" border="0"
        src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
        style="position: relative; left: 20px"
        alt="PayPal - The safer, easier way to pay online">
    </form>

    <form action = "http://dev.esewa.com.np/epay/main" method="POST" style="float:left; margin-right: 30px">
        <input value="0" name="txAmt" type="hidden"><!-- tax amount -->
        <input value="<?= PostServices::findOne($accept->accepted->order_id)->price; ?>" name="amt" type="hidden"><!-- price of the service -->
        <input value="0" name="psc" type="hidden"><!-- product service charge -->
        <input value="0" name="pdc" type="hidden"><!-- product delivery charge -->
        <input value="<?= PostServices::findOne($accept->accepted->order_id)->price; ?>" name="tAmt" type="hidden"><!-- total amount -->
        <input value="testmerchant" name="scd" type="hidden"><!-- merchant service code -->
        <input value="<?= $accept->post_id; ?>" name="pid" type="hidden"><!-- product id -->
        <input value="https://21143750.ngrok.com/everyjobSite/web/user/payment?=success&via=esewa" type="hidden" name="su"><!-- success url -->
        <input value="https://21143750.ngrok.com/everyjobSite/web/user/payment?=failure&via=esewa" type="hidden" name="fu"><!-- failure url -->
        <input value="" type="submit" style="background: url(<?= Yii::getAlias('@web/images/esewa.png');?>); height: 90px; width: 233px; border:none">
    </form>

    <span>
        <img src="<?= Yii::getAlias('@web/images/hellopaisa.png');?>" height="90">
    </span>

</td>
</tr>
</table>

</div>
</div><br>
<hr>
<?php } ?>

</div>
