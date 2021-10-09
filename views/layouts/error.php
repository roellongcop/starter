<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\ErrorAsset;
use app\helpers\App;
use app\helpers\Url;
use app\helpers\Html;

ErrorAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?= Url::image(App::setting('image')->favicon, ['w' => 16]) ?>" type="image/x-icon" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body id="kt_body" class="">
<?php $this->beginBody() ?>
	<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>