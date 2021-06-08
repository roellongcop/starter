<?php
use app\models\search\FileSearch;
use app\widgets\Anchor;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = 'File: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new FileSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="file-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model,
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
