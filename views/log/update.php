<?php

use app\models\search\LogSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Log */

$this->title = 'Update Log: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new LogSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="log-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>