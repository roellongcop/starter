<?php

use app\models\search\UserSearch;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Duplicate User: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => ['view', 'slug' => $originalModel->slug]];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new UserSearch();
$this->params['showCreateButton'] = true; 
?>
<div>
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
