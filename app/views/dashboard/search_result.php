<?php

use app\widgets\SearchResult;

$this->title = 'Dashboard';
$this->params['searchModel'] = $searchModel; 
?>
 
<?= SearchResult::widget([
	'dataProviders' => $dataProviders,
	'searchModel' => $searchModel,
]) ?>