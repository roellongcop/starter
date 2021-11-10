<?php

use app\models\search\UserMetaSearch;

/* @var $this yii\web\View */
/* @var $model app\models\UserMeta */

$this->title = 'Update User Meta: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'User Metas', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new UserMetaSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="user-meta-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>