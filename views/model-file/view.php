<?php
use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\ModelFileSearch;

/* @var $this yii\web\View */
/* @var $model app\models\ModelFile */

$this->title = 'Model File: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Model Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new ModelFileSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="model-file-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>