<?php

use app\models\search\BackupSearch;
use app\widgets\Anchor;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\Backup */

$this->title = 'Backup: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Backups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new BackupSearch();
$this->params['showCreateButton'] = true; 
?>

<div>
	<?= Anchor::widget([
		'title' => 'Download File',
		'link' => ['download', 'slug' => $model->slug],
		'options' => ['class' => 'btn btn-primary']
	]) ?>

	<?= Anchor::widget([
		'title' => 'Restore',
		'link' =>  ['restore', 'slug' => $model->slug],
		'options' => [
			'class' => 'btn btn-warning',
			'data-method' => 'post',
        	'data-confirm' => 'ARE YOU SURE?',
		]
	]) ?>
	<?= Anchors::widget([
		'names' => ['duplicate', 'delete', 'log'],
		'model' => $model,
	]) ?>
    <hr>
    <?= Detail::widget(['model' => $model]) ?>
</div>
