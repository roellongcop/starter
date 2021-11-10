<?php

use app\models\search\ThemeSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */

$this->title = 'Update Theme: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new ThemeSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="theme-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
