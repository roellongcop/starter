<?php

use app\models\search\BackupSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Backup */

$this->title = 'Duplicate Backup: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Backups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => ['view', 'slug' => $originalModel->slug]];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new BackupSearch();
?>

<div>
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>