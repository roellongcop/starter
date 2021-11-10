<?php

use app\models\search\FileSearch;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = 'Create File';
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new FileSearch();
?>
<div class="file-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>