<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-category-index col-sm-9">
<div class="alert alert-success">The category has been deleted successfully.</div>

    <h4 class="montserrat"><?= Html::encode($this->title) ?></h4>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>    
    <div class="clearfix"></div>    
    <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'category_id',
            'category_name:ntext',
            'created_date',
            //'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<div class="col-sm-3">
<div class="panel panel-info">
  <div class="panel-heading">Quick links</div>
  <div class="panel-body">
  <ul class="nav nav-pills  nav-stacked quick-links">
  <li>
    <a href="<?= Url::to(['/admin'])?>"><i class="fa fa-th"></i>Dashboard</a></li>
    <li><a href="<?= Url::to(['category/index'])?>"><i class="fa fa-th-list"></i>Categories</a></li>
    <li><a href="<?= Url::to(['category/create'])?>"><i class="fa fa-plus"></i>Add category</a></li>
    </ul>
    </div>
    </div>
</div>
