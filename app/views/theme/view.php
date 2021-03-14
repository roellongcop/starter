<?php

use app\models\search\ThemeSearch;
use app\widgets\Anchor;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */

$this->title = 'Theme: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['searchModel'] = new ThemeSearch();
$this->params['showCreateButton'] = true; 
?>

<div>
    <?= Anchors::widget([
    	'names' => ['update', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Anchor::widget([
    	'title' => 'Activate',
    	'link' => ['theme/activate', 'id' => $model->id],
    	'options' => [
    		'class' => 'btn btn-warning',
    		'data-method' => 'post',
    		'data-confirm' => 'Activate?'
    	]
    ]) ?> 
    <hr>
    <?= Detail::widget(['model' => $model]) ?>
</div>
