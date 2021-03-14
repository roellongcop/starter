<?php
use app\widgets\ConfirmCheckboxProcess;
use app\models\search\TestSearch;

$this->title = 'Confirm Action';
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new TestSearch();
?>
<?= ConfirmCheckboxProcess::widget([
	'models' => $models,
	'process' => $process,
    'post' => $post,
]) ?>
