<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\helpers\App;
use app\helpers\Url;
use app\widgets\Alert;
use app\widgets\Anchor;
use app\widgets\AnchorBack;
use app\widgets\Menu;
use app\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?= Url::image(App::setting('image')->favicon, ['w' => 16]) ?>" type="image/x-icon" />
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
                <?= AnchorBack::widget([
                    'title' => '<i class="fa fa-arrow-left"></i> Back',
                    'options' => [
                        'class' => 'btn btn-secondary',
                        'data-original-title' => 'Go back',
                        'data-toggle' => "tooltip",
                    ]
                ]) ?>
            </div>
            <div class="col-md-6 text-right">
                <?= Html::exportButton($this->params) ?>
            </div>
        </div>
        <?= $this->render('_search') ?>
        <br>
        <?= Html::createButton($this->params) ?>
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