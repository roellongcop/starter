<?php
use app\models\search\RoleSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = 'Create Role';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new RoleSearch();
?>
<div class="role-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>