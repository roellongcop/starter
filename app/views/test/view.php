<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\TestSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Test */

$this->title = 'Test: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['searchModel'] = new TestSearch();
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
