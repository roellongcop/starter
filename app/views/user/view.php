<?php

use app\models\search\UserSearch;
use app\widgets\Anchor;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = "User: {$model->username}";
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
$this->params['searchModel'] = new UserSearch();
$this->params['showCreateButton'] = true; 

?>

<div>
    <?= Anchors::widget([
    	'names' => ['update', 'delete', 'log'], 
    	'model' => $model
    ]) ?>  
    <?= Anchor::widget([
    	'title' => 'Profile', 
    	'link' => ['profile', 'id' => $model->id],
    	'options' => ['class' => 'btn btn-success']
    ]) ?>
    <?= Anchor::widget([
        'title' => 'User Dashboard', 
        'link' => ['user/dashboard', 'id' => $model->id],
        'options' => [
            'class' => 'btn btn-warning',
            'data-method' => 'post',
            'data-confirm' => 'Your account will be logout!'
        ]
    ]) ?>
    <hr>
    <?= Detail::widget(['model' => $model]) ?>
</div>
