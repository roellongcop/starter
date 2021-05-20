<?php

use app\models\search\IpSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = 'Duplicate Ip: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => ['view', 'slug' => $originalModel->slug]];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new IpSearch();
?>

<div>
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>