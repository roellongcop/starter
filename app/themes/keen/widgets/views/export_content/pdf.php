<?php
use \yii\grid\GridView;
use app\helpers\App;
?>
<div>
	<?= $reportName ?> Report
    <p style="font-size: 10px">
    	<?= $searchModel->startDate ?> - 
    	<?= $searchModel->endDate ?>
    </p> 
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => App::component('export')->getExportColumns($searchModel, 'pdf'),
    'layout' => "{items}",
    'formatter' => ['class' => '\app\components\FormatterComponent']
]);