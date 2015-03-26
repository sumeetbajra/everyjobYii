<?php

use yii\helpers\Html;
use app\models\User;
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
          	<td style="padding-left:25px"><a href="#" class="table-link"><?= \Yii::$app->function->getPostedServices($user->user_id); ?></a></td>
          	<td style="padding-left:25px"><a href="#" class="table-link"><?= \Yii::$app->function->getBoughtServices($user->user_id); ?></a></td>
          	<td><a href="#" class="btn btn-danger btn-sm">Deactivate</a>&nbsp;<a href="#" class="btn btn-primary btn-sm" title="Details"><i class="fa fa-info-circle"></i></a>
          	<a href="#" class="btn btn-primary btn-sm" title="Send message"><i class="fa fa-envelope"></i></a>
          	</a>
          	</td>
          	</tr>
          <?php } ?>
        </tbody>
    </table>
   