<?php
use yii\helpers\Html;
use app\widgets\BulkAction;
use app\widgets\FilterColumn;
use app\widgets\Grid;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ThemeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Themes';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['showCreateButton'] = true; 
$this->params['showExportButton'] = true;
?>
<div class="theme-index-page">
    <?= FilterColumn::widget(['searchModel' => $searchModel]) ?>
    <?= Html::beginForm(['confirm-action'], 'post'); ?>
        <?= BulkAction::widget(['searchModel' => $searchModel]) ?>
        <hr>
        <?= Grid::widget([
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'paramName' => 'slug',
            'template' => ['view', 'update', 'delete', 'activate'],
        ]); ?>
    <?= Html::endForm(); ?> 
</div>