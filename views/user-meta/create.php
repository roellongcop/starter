<?php

use app\models\search\UserMetaSearch;

/* @var $this yii\web\View */
/* @var $model app\models\UserMeta */

$this->title = 'Create User Meta';
$this->params['breadcrumbs'][] = ['label' => 'User Metas', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new UserMetaSearch();
?>
<div class="user-meta-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>