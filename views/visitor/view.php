<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\VisitorSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Visitor */

$this->title = 'Visitor: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Visitors', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new VisitorSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="visitor-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>