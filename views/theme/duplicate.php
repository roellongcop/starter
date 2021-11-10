<?php

use app\models\search\ThemeSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */

$this->title = 'Duplicate Theme: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new ThemeSearch();
$this->params['showCreateButton'] = true;
?>
<div class="ip-duplicate-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>