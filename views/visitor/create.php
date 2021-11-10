<?php

use app\models\search\VisitorSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Visitor */

$this->title = 'Create Visitor';
$this->params['breadcrumbs'][] = ['label' => 'Visitors', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new VisitorSearch();
?>
<div class="visitor-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>