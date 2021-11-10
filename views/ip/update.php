<?php

use app\models\search\IpSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = 'Update Ip: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new IpSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="ip-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>