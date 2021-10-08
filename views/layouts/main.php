<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\helpers\App;
use app\widgets\Alert;
use app\widgets\Anchor;
use app\widgets\ExportButton;
use app\widgets\Menu;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
$showExportButton = $this->params['showExportButton'] ?? '';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?= App::setting('image')->faviconPath ?>&w=16" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap"> 
    <?= Menu::widget() ?>
    <div class="container">
        <br> <br> <br> <br>
        <div class="row">
            <div class="col-md-6">
                <?php if (($referrer = App::referrer()) != null): ?>
                    <a href="<?= $referrer ?>" class="btn btn-secondary" title="Go Back">
                        <i class="fa fa-arrow-left"></i>
                        Back
                    </a>
                <?php endif ?>
            </div>
            <div class="col-md-6 text-right">
                <?php if ($showExportButton): ?>
                    <?= ExportButton::widget() ?>
                <?php endif ?>
            </div>
        </div>
        <?= $this->render('_search') ?>
        <br>
        <?= Anchor::widget([
            'title' => 'Create New',
            'link' => ['create'],
            'options' => ['class' => 'btn btn-success pull-right']
        ]) ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>