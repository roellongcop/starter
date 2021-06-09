<?php
use app\models\search\UserMetaSearch;

/* @var $this yii\web\View */
/* @var $model app\models\UserMeta */

$this->title = 'Duplicate User Meta: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'UserMetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new UserMetaSearch();
?>
<div class="user-meta-duplicate-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>