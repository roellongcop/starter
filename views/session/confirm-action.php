<?php
use app\models\search\SessionSearch;
use app\widgets\ConfirmCheckboxProcess;

$this->title = 'Confirm Action';
$this->params['breadcrumbs'][] = ['label' => 'Sessions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new SessionSearch();
?>
<div class="session-confirm-action-page">
	<?= ConfirmCheckboxProcess::widget([
		'models' => $models,
		'process' => $process,
	    'post' => $post,
	]) ?>
</div>