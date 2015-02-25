<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PostServices */

$this->title = 'Update Post Services: ' . ' ' . $model->post_id;
$this->params['breadcrumbs'][] = ['label' => 'Post Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->post_id, 'url' => ['view', 'id' => $model->post_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-services-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
