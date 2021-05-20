<?php

use app\models\search\UserSearch;
use app\widgets\Anchor;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'User: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new UserSearch();
$this->params['showCreateButton'] = true; 

?>

<div>
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model,
        'paramName' => 'slug'
    ]) ?>  
    <?= Anchor::widget([
    	'title' => 'Profile', 
    	'link' => ['profile', 'slug' => $model->slug],
    	'options' => ['class' => 'btn btn-success']
    ]) ?>
    <?= Anchor::widget([
        'title' => 'User Dashboard', 
        'link' => ['user/dashboard', 'slug' => $model->slug],
        'options' => [
            'class' => 'btn btn-warning',
            'data-method' => 'post',
            'data-confirm' => 'Your account will be logout!'
        ]
    ]) ?>
    <hr>
    <?= Detail::widget(['model' => $model]) ?>
</div>
