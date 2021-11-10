<?php

use app\models\search\QueueSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Queue */

$this->title = 'Create Queue';
$this->params['breadcrumbs'][] = ['label' => 'Queues', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new QueueSearch();
?>
<div class="queue-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>