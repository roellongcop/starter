<?php

use app\models\search\VisitLogSearch;

/* @var $this yii\web\View */
/* @var $model app\models\VisitLog */

$this->title = 'Update Visit Log: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Visit Logs', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new VisitLogSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="visit-log-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>