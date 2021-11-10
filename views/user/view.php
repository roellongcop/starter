<?php

use app\models\search\UserSearch;
use app\widgets\Anchor;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'User: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new UserSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="user-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model,
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

    <?= Anchor::widget([
        'title' => 'User Activities', 
        'link' => ['log/index', 'userSlug' => $model->slug],
        'options' => ['class' => 'btn btn-secondary']
    ]) ?>
    <?= Detail::widget(['model' => $model]) ?>
    <p class="lead">Profile</p>
    <?= Detail::widget(['model' => $model->profile]) ?>
</div>