<?php

use app\models\search\FileSearch;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = 'Update File: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new FileSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="file-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
