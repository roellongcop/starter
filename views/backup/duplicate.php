<?php

use app\models\search\BackupSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Backup */

$this->title = 'Duplicate Backup: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Backups', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new BackupSearch();
$this->params['showCreateButton'] = true;
?>
<div class="backup-duplicate-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>