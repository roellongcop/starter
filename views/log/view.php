<?php

use app\models\search\LogSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\Log */

$this->title = 'Log: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new LogSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="log-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete'], 
    	'model' => $model
    ]) ?>  
    <?= Detail::widget(['model' => $model]) ?>
</div>