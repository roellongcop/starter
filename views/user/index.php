<?php

use app\widgets\BulkAction;
use app\widgets\FilterColumn;
use app\widgets\Grid;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['showCreateButton'] = true; 
$this->params['showExportButton'] = true;
?>
 
<div>
    <?= FilterColumn::widget(['searchModel' => $searchModel]) ?>
    <?= Html::beginForm(['process-checkbox'], 'post'); ?>
	<?= BulkAction::widget(['searchModel' => $searchModel]) ?>
	<hr>
    <?= Grid::widget([
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'paramName' => 'slug'
    ]); ?>
                   
    <?= Html::endForm(); ?> 
</div>
