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
        <h3 class="montserrat">You have no accpeted orders</h3>
        <?php else: ?>
        <h3 class="montserrat">Your accepted order(s)</h3>
        Your orders are complete once you make the payments.
        <?php endif; ?>
<hr>

<?php foreach($accepted as $accept){?>
    <div class="post-order">

        <div class="row">
            <h4 class="montserrat"><?= $title = PostServices::findOne($accept->post_id)->title; ?></h4>
            <b>Owner: </b><a href ="<?= Url::to(['user/profile/'.Users::findOne($accept->user_id)->display_name]); ?>"><?= Users::findOne($accept->user_id)->display_name; ?></a><br>
            <h4>Choose payment option: </h4>
            <?php
            $url = 'http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency=NPR&ToCurrency=USD';
            $xml = simpleXML_load_file($url,"SimpleXMLElement",LIBXML_NOCDATA);
            if($xml ===  FALSE)
            {
               //deal with error
            }
            else { 
                $rate = $xml;
                $price = PostServices::findOne($accept->accepted->order_id)->price * "$rate[0]";
            }
            ?>

            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="return" value="https://3dea67e3.ngrok.com/everyjobSite/web/paypal/paypalipn">
<input type="hidden" name="business" value="sumeetbajra@gmail.com">
<input type="hidden" name="item_name" value="<?= $title;?>">
<input type="hidden" name="item_number" value="<?= $accept->post_id; ?>">
<input type="hidden" name="amount" value="<?= $price; ?>">
<input type="hidden" name="custom" value="<?= $price; ?>">
<input type="hidden" name="tax" value="0">
<input type="hidden" name="quantity" value="1">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="no_shipping" value="1">

<input type="image" name="submit" border="0"
src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
alt="PayPal - The safer, easier way to pay online">
</form>
           
        </div>
    </div><br>
<hr>
<?php } ?>




</div>

</div>
