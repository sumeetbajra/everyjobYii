<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PostCategory */

$this->title = $model->category_name;
$this->params['breadcrumbs'][] = ['label' => 'Post Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-category-view col-sm-9">

    <h4><?= Html::encode($this->title) ?></h4><hr>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->category_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->category_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'category_id',
            'category_name:ntext',
            'created_date',
//            'created_by',
        ],
    ]) ?>

</div>

<div class="col-sm-3">
<div class="panel panel-info">
  <div class="panel-heading">Quick links</div>
  <div class="panel-body">
  <ul class="nav nav-pills  nav-stacked quick-links">
  <li>
    <a href="<?= Url::to(['/admin'])?>"><i class="fa fa-th"></i>Dashboard</a></li>
    <li><a href="<?= Url::to(['category/index'])?>"><i class="fa fa-th-list"></i>Categories</a></li>
    <li><a href="#"><i class="fa fa-user"></i>Admin details</a></li>
    <li><a href="<?= Url::to(['category/index'])?>"><i class="fa fa-chevron-circle-left"></i>Back</a></li>
    </ul>
    </div>
    </div>
</div>
</div>