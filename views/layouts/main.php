<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('Everyjob Backend') ?></title>
    <link href="<?= Yii::getAlias('@web'); ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web'); ?>/css/site.css" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web/css/font-awesome.min.css')?>" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web'); ?>/css/fileinput.css" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web'); ?>/css/datatable.css" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body>

    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'everyjob',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->display_name . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container" id="admin-container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; everyjob <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
<script src="<?= Yii::getAlias('@web'); ?>/js/jquery.js"></script>
    <script src="<?= Yii::getAlias('@web'); ?>/js/admin.js"></script>
    <script src="<?= Yii::getAlias('@web'); ?>/js/datatable.js"></script>
</body>
</html>
<?php $this->endPage() ?>
