<?php
use app\models\search\ModelFileSearch;

/* @var $this yii\web\View */
/* @var $model app\models\ModelFile */

$this->title = 'Duplicate Model File: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Model Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new ModelFileSearch();
?>
<div class="model-file-duplicate-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>