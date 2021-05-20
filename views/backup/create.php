<?php

use app\models\search\BackupSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Backup */

$this->title = 'Create Backup';
$this->params['breadcrumbs'][] = ['label' => 'Backups', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new BackupSearch();
?>

<div>
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>