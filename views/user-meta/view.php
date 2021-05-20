<?php

use app\models\search\UserMetaSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\UserMeta */

$this->title = 'User Meta: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Metas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
$this->params['searchModel'] = new UserMetaSearch();
$this->params['showCreateButton'] = true; 
?>

<div>
    <?= Anchors::widget([
    	'names' => ['update', 'delete', 'log'], 
    	'model' => $model
    ]) ?>  
    <hr>
    <?= Detail::widget(['model' => $model]) ?>
</div>
