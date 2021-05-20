<?php

use app\models\search\SessionSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Session */

$this->title = 'Create Session';
$this->params['breadcrumbs'][] = ['label' => 'Sessions', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new SessionSearch();
?>

<div>
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>