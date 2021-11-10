<?php

use app\models\search\QueueSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Queue */

$this->title = 'Update Queue: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Queues', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new QueueSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="queue-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>