<?php

use app\models\search\UserSearch;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Update User: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => ['view', 'slug' => $model->slug]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new UserSearch();
$this->params['showCreateButton'] = true; 
?>
<div>
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
