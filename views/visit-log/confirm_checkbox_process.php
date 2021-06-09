<?php
use app\models\search\VisitLogSearch;
use app\widgets\ConfirmCheckboxProcess;

$this->title = 'Confirm Action';
$this->params['breadcrumbs'][] = ['label' => 'Visit Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new VisitLogSearch();
?>
<div class="visit-log-confirm-action-page">
	<?= ConfirmCheckboxProcess::widget([
		'models' => $models,
		'process' => $process,
	    'post' => $post,
	]) ?>
</div>