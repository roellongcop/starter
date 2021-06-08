<?php
use app\models\search\BackupSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Backup */

$this->title = 'Duplicate Backup: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Backups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new BackupSearch();
?>
<div class="backup-duplicate-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>