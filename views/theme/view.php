<?php

use app\models\search\ThemeSearch;
use app\widgets\Anchor;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */

$this->title = 'Theme: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new ThemeSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="theme-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Anchor::widget([
    	'title' => 'Activate',
    	'link' => ['theme/activate', 'slug' => $model->slug],
    	'options' => [
    		'class' => 'btn btn-warning',
    		'data-method' => 'post',
    		'data-confirm' => 'Activate?'
    	]
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>