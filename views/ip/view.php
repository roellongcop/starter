<?php

use app\models\search\IpSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\Ip */

$this->title = 'IP: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new IpSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="ip-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model,
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>