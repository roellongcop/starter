<?php

use app\models\search\LogSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Log */

$this->title = 'Update Log: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new LogSearch();
$this->params['showCreateButton'] = true; 
?>
<div>
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
