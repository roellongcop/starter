<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\ModelFileSearch;

/* @var $this yii\web\View */
/* @var $model app\models\ModelFile */

$this->title = 'Model File: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Model Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
$this->params['searchModel'] = new ModelFileSearch();
$this->params['showCreateButton'] = true; 
?>

<div>
    <?= Anchors::widget([
    	'names' => ['update', 'delete'], 
    	'model' => $model
    ]) ?> 
    <hr>
    <?= Detail::widget(['model' => $model]) ?>
</div>
