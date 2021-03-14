<?php

use app\models\search\FileSearch;
use app\widgets\Anchor;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = "File: {$model->name}";
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['searchModel'] = new FileSearch();
$this->params['showCreateButton'] = true; 
?>

<div>
    <?= Anchors::widget([
    	'names' => ['update', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Anchor::widget([
    	'title' => 'Download', 
    	'link' => ['file/download', 'token' => $model->token],
    	'options' => [
    		'class' => 'btn btn-success'
    	]
    ]) ?> 
    <hr>
    <?= Detail::widget(['model' => $model]) ?>
</div>
