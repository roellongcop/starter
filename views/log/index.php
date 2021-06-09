<?php
use app\widgets\BulkAction;
use app\widgets\FilterColumn;
use app\widgets\Grid;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logs';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['showCreateButton'] = true; 
$this->params['showExportButton'] = true;
?>
<div class="log-index-page">
    <?= FilterColumn::widget(['searchModel' => $searchModel]) ?>
    <?= Html::beginForm(['confirm-action'], 'post'); ?>
	<?= BulkAction::widget(['searchModel' => $searchModel]) ?>
    <hr>
    <?= Grid::widget([
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]); ?>    
    <?= Html::endForm(); ?> 
</div>