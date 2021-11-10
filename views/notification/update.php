<?php

use app\models\search\NotificationSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Notification */

$this->title = 'Update Notification: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Notifications', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new NotificationSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="notification-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>