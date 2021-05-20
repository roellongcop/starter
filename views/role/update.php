<?php

use app\models\search\RoleSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = 'Update Role: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new RoleSearch();
$this->params['showCreateButton'] = true; 
?>
<div>
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
