<?php

use yii\helpers\Html;
use app\models\User;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cash Withdrawal Requests';
$this->params['breadcrumbs'][] = 'Cash Withdrawal';
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
                <th>Transaction_Id</th>
                <th>User</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Requested</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
 
        <tfoot>
                <tr>
                <th>Transaction_Id</th>
                <th>User</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Requested</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </tfoot>
 
        <tbody>
            <?php foreach ($transaction as $key => $transaction) {?>
            <tr>
                <td>
                    <?= Html::encode($transaction->transaction_id); ?>
                </td>
                <td>
                   <a href="<?= Url::to(['admin/user/'.$transaction->post->owner_id]); ?>"><?= Html::encode($transaction->post->owner->display_name); ?></a>
                </td>
                <td>
                    <?= date('M d, Y', strtotime($transaction->datetimestamp)); ?>
                </td>
                <td>
                    <?= "Rs. " . $transaction->post_price; ?>
                </td>
                <td>
                   <?= date('M d, Y', strtotime($transaction->withdraw->request_date)); ?>
                </td>
                <td>
                    <?= $transaction->payment_status; ?>
                </td>
                <td>
                     <a href="<?= Url::to(['payment/masspayment/?transaction='.$transaction->transaction_id]); ?>" class="btn btn-primary btn-sm">Approve</a>
                </td>
            </tr>
                
            <?php } ?>
        </tbody>
     </table>
   
