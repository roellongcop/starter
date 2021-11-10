<?php

use app\models\search\IpSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = 'Duplicate Ip: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new IpSearch();
$this->params['showCreateButton'] = true;
?>
<div class="ip-duplicate-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>