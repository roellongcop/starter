<?php

use app\models\search\NotificationSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Notification */

$this->title = 'Duplicate Notification: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Notifications', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new NotificationSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="notification-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>