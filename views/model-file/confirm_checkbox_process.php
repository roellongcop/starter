<?php
use app\widgets\ConfirmCheckboxProcess;
use app\models\search\ModelFileSearch;

$this->title = 'Confirm Action';
$this->params['breadcrumbs'][] = ['label' => 'Model Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new ModelFileSearch();
?>
<div class="model-file-confirm-action-page">
	<?= ConfirmCheckboxProcess::widget([
		'models' => $models,
		'process' => $process,
	    'post' => $post,
	]) ?>
</div>