<?php

use app\widgets\ConfirmCheckboxProcess;
use app\models\search\NotificationSearch;

$this->title = 'Confirm Action';
$this->params['breadcrumbs'][] = ['label' => 'Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new NotificationSearch();
?>
<div class="notification-confirm-action-page">
	<?= ConfirmCheckboxProcess::widget([
		'models' => $models,
		'process' => $process,
	    'post' => $post,
	]) ?>
</div>