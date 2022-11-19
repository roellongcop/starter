<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\themes\keen\assets\KeenAsset;
use app\themes\keen\sub\demo1\main\assets\AppAsset;

AppAsset::register($this);
KeenAsset::register($this);

$sleep = $this->params['sleep'] ?? 1300;

$this->registerJs(<<< JS
    const sleep = ms => new Promise(resolve => setTimeout(resolve, ms));
    (async () => {
        await sleep({$sleep});
        window.print()
    })();
JS);
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
    <style type="text/css">
        table { page-break-inside:auto; }
        tr    { page-break-inside:avoid;}
        thead { display:table-header-group; }
        tfoot { display:table-footer-group;}
        body {
            background-color: #fff;
            width: 100%;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                width: 100%;
            }
        }
        @page { 
            size: A4;
            margin: 0.3in 0.5in;
            -webkit-print-color-adjust: exact;
        }
    </style>
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