<?php
use app\models\search\VisitLogSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\VisitLog */

$this->title = 'Visit Log: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Visit Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new VisitLogSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="visit-log-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'delete', 'log'], 
    	'model' => $model
    ]) ?>  
    <hr>
    <?= Detail::widget(['model' => $model]) ?>
</div>