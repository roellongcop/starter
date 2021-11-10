<?php

use app\models\search\RoleSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = 'Update Role: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new RoleSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="role-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>