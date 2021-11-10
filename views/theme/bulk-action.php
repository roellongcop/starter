<?php

use app\models\search\ThemeSearch;
use app\widgets\ConfirmBulkAction;

$this->title = 'Confirm Bulk Action';
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = new ThemeSearch();
$this->params['showCreateButton'] = true;
?>
<div class="theme-bulk-action-page">
	<?= ConfirmBulkAction::widget([
		'models' => $models,
		'process' => $process,
	    'post' => $post,
	]) ?>
</div>