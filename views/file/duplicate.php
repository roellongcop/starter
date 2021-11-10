<?php

use app\models\search\FileSearch;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = 'Duplicate File: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new FileSearch();
$this->params['showCreateButton'] = true;
?>
<div class="file-duplicate-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>