<?php

use app\models\search\ThemeSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */

$this->title = 'Create Theme';
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new ThemeSearch();
?>
<div class="theme-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>