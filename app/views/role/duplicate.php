<?php

use app\models\search\RoleSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = 'Duplicate Role: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => ['view', 'id' => $originalModel->id]];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new RoleSearch();
$this->params['showCreateButton'] = true; 
?>
<div>
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
