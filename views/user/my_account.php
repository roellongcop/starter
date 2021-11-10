<?php

use app\models\search\UserSearch;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Update Account';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => ['view', 'slug' => $model->slug]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new UserSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="user-my-account-page">
	<?= $this->render('_form_my_account', [
        'model' => $model,
    ]) ?>
</div>