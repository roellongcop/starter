<?php

use app\models\search\SessionSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\Session */

$this->title = 'Session: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Sessions', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new SessionSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="session-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'delete', 'log'], 
    	'model' => $model
    ]) ?>  
    <?= Detail::widget(['model' => $model]) ?>
</div>