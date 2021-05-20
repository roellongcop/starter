<?php

use app\models\search\IpSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = 'Update Ip: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => ['view', 'slug' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new IpSearch();
$this->params['showCreateButton'] = true; 
?>
<div>
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
