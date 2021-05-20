<?php

use app\models\search\UserMetaSearch;

/* @var $this yii\web\View */
/* @var $model app\models\UserMeta */

$this->title = 'Update User Meta: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Metas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new UserMetaSearch();
$this->params['showCreateButton'] = true; 
?>
<div>
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
