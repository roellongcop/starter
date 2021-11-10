<?php

use app\models\search\LogSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Log */

$this->title = 'Create Log';
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new LogSearch();
?>
<div class="log-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>