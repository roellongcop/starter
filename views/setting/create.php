<?php

use app\models\search\SettingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */

$this->title = 'Create Setting';
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new SettingSearch();
?>
<div class="setting-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>