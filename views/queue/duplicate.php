<?php

use app\models\search\QueueSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Queue */

$this->title = 'Duplicate Queue: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Queues', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new QueueSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="queue-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>