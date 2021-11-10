<?php

use app\models\search\LogSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Log */

$this->title = 'Duplicate Log: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new LogSearch();
$this->params['showCreateButton'] = true;
?>
<div class="log-duplicate-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>