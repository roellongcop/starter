<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\QueueSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Queue */

$this->title = 'Queue: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Queues', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new QueueSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="queue-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>