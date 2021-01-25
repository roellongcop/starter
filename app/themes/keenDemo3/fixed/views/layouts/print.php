<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\search\SettingSearch;
use app\themes\keenDemo3\fixed\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
// use app\assets\MainAsset;


AppAsset::register($this);
// MainAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?= SettingSearch::defaultImage('favicon') ?>&w=16" type="image/x-icon" />
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
