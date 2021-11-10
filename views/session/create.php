<?php

use app\models\search\SessionSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Session */

$this->title = 'Create Session';
$this->params['breadcrumbs'][] = ['label' => 'Sessions', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new SessionSearch();
?>
<div class="session-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>