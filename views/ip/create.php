<?php

use app\models\search\IpSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = 'Create Ip';
$this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new IpSearch();
?>
<div class="ip-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>