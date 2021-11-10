<?php

use app\models\search\BackupSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Backup */

$this->title = 'Update Backup: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Backups', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new BackupSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="backup-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>