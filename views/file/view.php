<?php

use app\helpers\Html;
use app\models\search\FileSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = 'File: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new FileSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="file-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model,
    ]) ?> 
    <?= Html::a('Download', ['file/download', 'token' => $model->token], [
        'class' => 'btn btn-success'
    ]) ?>
    <?= Detail::widget(['model' => $model]) ?>
</div>
