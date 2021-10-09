<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\helpers\App;
use app\themes\keen\assets\KeenAsset;
use app\themes\keen\sub\demo3\fixed\assets\KeenDemo3FixedAppAsset;
use app\helpers\Html;
use app\helpers\Url;

KeenDemo3FixedAppAsset::register($this);
KeenAsset::register($this);
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
    <script type="text/javascript">
        var base_url = "<?= Url::home(true) ?>"
    </script>
</head>
<body>
<?php $this->beginBody() ?>
    <!-- begin:: Page --> 
    <?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>