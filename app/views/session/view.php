<?php

use app\models\search\SessionSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\Session */

$this->title = 'Session: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Sessions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new SessionSearch();
$this->params['showCreateButton'] = true; 
?>

<div>
    <?= Anchors::widget([
    	'names' => ['update', 'delete', 'log'], 
    	'model' => $model
    ]) ?>  
    <hr>
    <?= Detail::widget(['model' => $model]) ?>
</div>
