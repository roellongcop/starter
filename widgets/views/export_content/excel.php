<?php
use \yii\grid\GridView;
use app\helpers\App;
use app\models\form\export\ExportForm;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => (new ExportForm())->getExportColumns($searchModel),
    'layout' => "{items}",
    'formatter' => ['class' => '\app\components\FormatterComponent']
]); ?>