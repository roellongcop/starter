<?php

use app\models\search\IpSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'IP: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Ips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new IpSearch();
$this->params['showCreateButton'] = true; 
?>

<div>
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model,
    ]) ?> 
    <hr>
    <?= Detail::widget(['model' => $model]) ?>
</div>
