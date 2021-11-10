<?php

use app\models\search\NotificationSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Notification */

$this->title = 'Create Notification';
$this->params['breadcrumbs'][] = ['label' => 'Notifications', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new NotificationSearch();
?>
<div class="notification-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>