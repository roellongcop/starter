<?php

use app\models\search\UserSearch;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Duplicate User: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new UserSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="user-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>