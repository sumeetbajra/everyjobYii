<style>
.tdcenter tbody tr td{
  text-align: center;
}

.tdcenter tbody tr td:nth-child(3){
  text-align: left;
}

.montserrat{
  display: inline-block;
}
</style>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\Users;
use app\models\PostViews;
use app\models\PostRatings;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Services posted by users';
$this->params['breadcrumbs'][] = $this->title;
$ratings = new PostRatings;
?>
<?php if(Yii::$app->session->getFlash('message')){ ?>
    <div class="col-md-12 alert alert-success alert-dismissible">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= Yii::$app->session->getFlash('message'); ?></div>
    <?php } ?>
<div class="post-category-index col-sm-12">

    <h4 class="montserrat"><?= Html::encode($this->title) ?></h4>&nbsp;&nbsp;<a href="<?= Url::to(['/admin/posts'])?>"><i class="fa fa-arrow-circle-o-left"></i> Back to gridview</a>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>    
    <div class="clearfix"></div>    
    <hr>  
  With selected: <select name="actions">
  <option value="">--Select--</option>
  <option value="delete">Delete</option>
  <option value="add">Add to featured</option>
  <option value="remove">Remove from featured</option>
  </select> <a class="btn btn-sm btn-default go">Go</a>
<br><br>
  <table id="myTable" class="table table-striped tdcenter">
    <thead>
      <tr>
        <td>
          <input type="checkbox" name="postsCheckAll">
        </td>
        <td>
          Id
        </td>
        <td>
          Title
        </td>
        <td>
          Owner
        </td>
        <td>
          Price
        </td>
        <td>
          Posted
        </td>
        <td>
          Sold
        </td>
        <td>
          Active Orders
        </td>
        <td>
          Views
        </td>
        <td>
          Likes
        </td>
        <td>
          Dislikes
        </td>
        <td>
          Actions
        </td>
      </tr>
    </thead>

    <tbody>
      <?php foreach($posts as $post): ?>
      <tr>
        <td>
          <input type="checkbox" name="postsCheck[]" id="post_<?= $post->post_id;?>">
        </td>
        <td>
          <?= $post->post_id;?>
        </td>
        <td>
          <?= substr(Html::encode($post->title), 0, 34); ?>...
        </td>
        <td>
          <a href="<?= Url::to(['user/profile/'.Users::findOne($post->owner_id)->display_name]); ?>"><?= Users::findOne($post->owner_id)->display_name; ?></a>
        </td>
        <td>
          Rs. <?= $post->price; ?>
        </td>
        <td>
          <?= date('M d, Y', strtotime($post->datetimestamp)); ?>
        </td>
        <td>
          <?= \Yii::$app->function->getSoldCount($post->post_id);?>
        </td>
        <td>
          <?= \Yii::$app->function->getOrderCount($post->post_id);?>
        </td>
        <td>
          <?= (PostViews::find()->where(['post_id'=>$post->post_id])->count() == 0 ? 0 : PostViews::find()->where(['post_id'=>$post->post_id])->one()->view_count);?>
        </td>
        <td>
          <?= $ratings->postRating($post->post_id)['likes'];?>
        </td>
        <td>
          <?= $ratings->postRating($post->post_id)['dislikes'];?>
        </td>
        <td>
          <a class="btn btn-sm btn-danger" onclick="bootbox.confirm('Are you sure?', function(response){if(response){window.location='<?= Url::to(['post/delete/'.$post->post_id]);?>'}});">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>

    <tfoot>
      <tr>
        <td>
          <input type="checkbox" name="postsCheckAll">
        </td>
        <td>
          Id
        </td>
        <td>
          Title
        </td>
        <td>
          Owner
        </td>
        <td>
          Price
        </td>
        <td>
          Date
        </td>
        <td>
          Sold
        </td>
        <td>
          Active Orders
        </td>
        <td>
          Views
        </td>
        <td>
          Likes
        </td>
        <td>
          Dislikes
        </td>
        <td>
          Actions
        </td>
      </tr>
    </tfoot>
  </table>
</div>
<br>
  With selected: <select>
  <option value="">--Select--</option>
  <option value="delete">Delete</option>
  <option value="add">Add to featured</option>
  <option value="remove">Remove from featured</option>
  </select> <a class="btn btn-sm btn-default go">Go</a>
