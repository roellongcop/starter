<?php

use app\models\search\SessionSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Session */

$this->title = 'Update Session: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Sessions', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new SessionSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="session-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>