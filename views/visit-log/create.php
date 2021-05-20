<?php

use app\models\search\VisitLogSearch;

/* @var $this yii\web\View */
/* @var $model app\models\VisitLog */

$this->title = 'Create Visit Log';
$this->params['breadcrumbs'][] = ['label' => 'Visit Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new VisitLogSearch();
?>

<div>
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>