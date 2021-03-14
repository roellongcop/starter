<?php

use app\models\search\TestSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Test */

$this->title = 'Create Test';
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new TestSearch();
?>

<div>
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>