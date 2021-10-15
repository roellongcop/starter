<?php

use app\helpers\App;
use app\models\form\export\ExportForm;
use yii\grid\GridView;
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
    'columns' => (new ExportForm())->getExportColumns($searchModel, 'pdf'),
    'layout' => "{items}",
    'formatter' => ['class' => '\app\components\FormatterComponent']
]); ?>