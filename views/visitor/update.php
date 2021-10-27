<?php

use app\models\search\VisitorSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Visitor */

$this->title = 'Update Visitor: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Visitors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new VisitorSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="visitor-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>