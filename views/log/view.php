<?php

use app\models\search\LogSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\Log */

$this->title = 'Log: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new LogSearch();
$this->params['showCreateButton'] = true; 
?>

<div>
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?>  
    <hr>
    <?= Detail::widget(['model' => $model]) ?>
</div>
