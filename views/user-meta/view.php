<?php

use app\models\search\UserMetaSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\UserMeta */

$this->title = 'User Meta: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'User Metas', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new UserMetaSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="user-meta-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?>  
    <?= Detail::widget(['model' => $model]) ?>
</div>