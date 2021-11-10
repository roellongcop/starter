<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\NotificationSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Notification */

$this->title = 'Notification: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Notifications', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new NotificationSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="notification-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>