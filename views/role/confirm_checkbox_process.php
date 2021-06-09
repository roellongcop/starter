<?php
use app\models\search\RoleSearch;
use app\widgets\ConfirmCheckboxProcess;

$this->title = 'Confirm Action';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new RoleSearch();
?>
<div class="role-confirm-action-page">
	<?= ConfirmCheckboxProcess::widget([
		'models' => $models,
		'process' => $process,
	    'post' => $post,
	]) ?>
</div>