<?php

use app\models\search\SettingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */

$this->title = 'Update Setting: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new SettingSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="setting-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>