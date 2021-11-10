<?php

use app\models\search\RoleSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = 'Role: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new RoleSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="role-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model,
    ]) ?>  
    <?= Detail::widget(['model' => $model]) ?>
</div>