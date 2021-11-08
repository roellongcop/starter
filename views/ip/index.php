<?php

use app\widgets\BulkAction;
use app\widgets\FilterColumn;
use app\widgets\Grid;
use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\IpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ips';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['showCreateButton'] = true; 
$this->params['showExportButton'] = true;
?>
<div class="ip-index-page">
    <?= FilterColumn::widget(['searchModel' => $searchModel]) ?>
    <?= Html::beginForm(['bulk-action'], 'post'); ?>
	<?= BulkAction::widget(['searchModel' => $searchModel]) ?>
    <?= Grid::widget([
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    	'paramName' => 'slug',
    ]); ?>
    <?= Html::endForm(); ?> 
</div>