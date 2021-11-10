<?php

use app\models\search\VisitorSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Visitor */

$this->title = 'Duplicate Visitor: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Visitors', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new VisitorSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="visitor-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>