<?php

use app\models\search\ModelFileSearch;

/* @var $this yii\web\View */
/* @var $model app\models\ModelFile */

$this->title = 'Update Model File: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Model Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new ModelFileSearch();
$this->params['showCreateButton'] = true; 
?>
<div>
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
