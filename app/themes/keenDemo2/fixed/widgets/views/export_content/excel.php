<?php
use \yii\grid\GridView;
use app\helpers\App;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => App::component('export')->getExportColumns($searchModel),
    'layout' => "{items}",
    'formatter' => ['class' => '\app\components\FormatterComponent']
]); ?>
