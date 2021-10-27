<?php

use app\models\search\RoleSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = 'My Role: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new RoleSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="role-my-role-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>