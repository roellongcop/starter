<?php

use app\helpers\Html;
use app\models\search\BackupSearch;
use app\widgets\Anchor;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\Backup */

$this->title = 'Backup: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Backups', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new BackupSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="backup-view-page">
	<?= Html::if($model->generated, function() use($model) {
		return implode(' ', [
			Anchor::widget([
				'title' => 'Download SQL',
				'link' => ['download', 'slug' => $model->slug],
				'options' => ['class' => 'btn btn-primary btn-download-sql']
			]),
			Anchor::widget([
				'title' => 'Restore',
				'link' =>  ['restore', 'slug' => $model->slug],
				'options' => [
					'class' => 'btn btn-warning btn-restore-sql',
					'data-method' => 'post',
		        	'data-confirm' => 'ARE YOU SURE?',
				]
			])
		]);
	}) ?>
	<?= Anchors::widget([
		'names' => ['duplicate', 'delete', 'log'],
		'model' => $model,
	]) ?>
    <?= Detail::widget(['model' => $model]) ?>
</div>