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
  <ul class="quick-links">
  <li>
    <a href="<?= Url::to(['site/admin'])?>"><li><i class="fa fa-th"></i> Dashboard</a></li>
    <li><a href="<?= Url::to(['category/index'])?>"><li><i class="fa fa-th-list"></i> Categories<br></a></li>
    <li><a href="<?= Url::to(['category/create'])?>"><li><i class="fa fa-plus"></i> Create<br></a></li>
    <li><i class="fa fa-paper-plane"></i> Service posts<br></li>
    <li><i class="fa fa-comments"></i> Moderate Comments<br></li>
    </ul>
    </div>
    </div>
</div>
