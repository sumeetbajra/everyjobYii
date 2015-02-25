<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PostServices */

$this->title = $model->post_id;
$this->params['breadcrumbs'][] = ['label' => 'Post Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-services-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->post_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->post_id], [
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
            'post_id',
            'description:ntext',
            'category_id',
            'owner_id',
            'price',
            'image_url:url',
            'expiry_date',
            'datetimestamp',
            'max_active_orders',
            'max_delivery_days',
            'active',
        ],
    ]) ?>

</div>
