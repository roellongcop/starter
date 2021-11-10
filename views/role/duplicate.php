<?php
use app\models\search\RoleSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = 'Duplicate Role: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new RoleSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="role-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>