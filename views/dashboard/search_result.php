<?php

use app\widgets\SearchResult;

$this->title = 'Dashboard';
$this->params['searchModel'] = $searchModel; 
?>

<div class="dashboard-seach-result-page">
	<?= SearchResult::widget([
		'dataProviders' => $dataProviders,
		'searchModel' => $searchModel,
	]) ?>
</div>