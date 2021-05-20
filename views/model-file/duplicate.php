<?php

use app\models\search\ModelFileSearch;

/* @var $this yii\web\View */
/* @var $model app\models\ModelFile */

$this->title = 'Duplicate Model File: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Model Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => ['view', 'id' => $originalModel->id]];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new ModelFileSearch();
?>

<div>
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>