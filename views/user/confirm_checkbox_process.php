<?php
use app\models\search\UserSearch;
use app\widgets\ConfirmCheckboxProcess;

$this->title = 'Confirm Action';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new UserSearch();


?>
  

<?= ConfirmCheckboxProcess::widget([
	'models' => $models,
	'process' => $process,
    'post' => $post,
]) ?>