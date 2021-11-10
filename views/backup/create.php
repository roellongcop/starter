<?php

use app\models\search\BackupSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Backup */

$this->title = 'Create Backup';
$this->params['breadcrumbs'][] = ['label' => 'Backups', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new BackupSearch();
?>
<div class="backup-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>