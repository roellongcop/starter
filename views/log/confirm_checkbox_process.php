<?php
use app\models\search\LogSearch;
use app\widgets\ConfirmCheckboxProcess;

$this->title = 'Confirm Action';
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new LogSearch();


?>
<?= ConfirmCheckboxProcess::widget([
	'models' => $models,
	'process' => $process,
    'post' => $post,
]) ?>