<?php

use app\models\search\SettingSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */

$this->title = 'Setting: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new SettingSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="setting-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'delete', 'log'], 
    	'model' => $model
    ]) ?>  
    <?= Detail::widget(['model' => $model]) ?>
</div>