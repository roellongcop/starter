<?php

use app\models\search\LogSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Log */

$this->title = 'Duplicate Log: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => ['view', 'id' => $originalModel->id]];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new LogSearch();
?>

<div>
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>