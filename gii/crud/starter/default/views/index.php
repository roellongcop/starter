<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use app\widgets\BulkAction;
use app\widgets\FilterColumn;
use <?= $generator->indexWidgetType === 'grid' ? "app\\widgets\\Grid" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['showCreateButton'] = true; 
$this->params['showExportButton'] = true;
?>

 
<div>
    <?= "<?=" ?> FilterColumn::widget(['searchModel' => $searchModel]) ?>
    <?= "<?=" ?> Html::beginForm(['confirm-action'], 'post'); ?>
        <?= "<?=" ?> BulkAction::widget(['searchModel' => $searchModel]) ?>
        <hr>
        <?= $generator->enablePjax ? "    <?php Pjax::begin(); ?>\n" : '' ?>
        <?php if ($generator->indexWidgetType === 'grid'): ?>

        <?= "<?=" ?> Grid::widget([
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]); ?>
        <?php else: ?>
        <?= "<?= " ?>ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
                return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
            },
        ]) ?>
        <?php endif; ?>
        <?= $generator->enablePjax ? "    <?php Pjax::end(); ?>\n" : '' ?>
                
    <?= '<?=' ?> Html::endForm(); ?> 
</div>
