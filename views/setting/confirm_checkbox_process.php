<?php
use app\models\search\SettingSearch;
use app\widgets\ConfirmCheckboxProcess;

$this->title = 'Confirm Action';
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new SettingSearch();


?>
<?= ConfirmCheckboxProcess::widget([
	'models' => $models,
	'process' => $process,
    'post' => $post,
]) ?>