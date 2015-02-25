<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PostServices */

?>
<div class="row" style="">

	<div class="col-md-12">
    <h3 class="montserrat">Create New Post</h3>
    Post a new service for free. Make it descriptive in order to attract buyers.
    <hr>

    <?= $this->render('_form', [
        'model' => $model,
        'categories'=>$categories,
    ]) ?>
</div>

</div>
