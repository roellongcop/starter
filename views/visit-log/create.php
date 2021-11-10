<?php

use app\models\search\VisitLogSearch;

/* @var $this yii\web\View */
/* @var $model app\models\VisitLog */

$this->title = 'Create Visit Log';
$this->params['breadcrumbs'][] = ['label' => 'Visit Logs', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new VisitLogSearch();
?>
<div class="visit-log-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>