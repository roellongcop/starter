<?php

use app\helpers\App;
use app\models\ActiveRecord;
use app\widgets\ActiveForm;
use app\widgets\Checkbox;
use app\widgets\DateRange;
use app\widgets\Filter;
use app\widgets\Pagination;
use app\widgets\Search;
use app\widgets\SearchButton;

/* @var $this yii\web\View */
/* @var $form app\widgets\ActiveForm */
$modules = App::access('searchModels');
$model->modules = $model->modules ?: array_keys($modules);
$modules['*checkAll'] = ['name' => 'Check All', 'tags' => 'onclick="checkAllAccessModule(this)"'];
ksort($modules);
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'options' => ['class' => 'kt-quick-search__form']
]); ?>
    <?= Search::widget(['model' => $model]) ?>
    <?= DateRange::widget([
        'model' => $model,
        'start' => $model->startDate(),
        'end' => $model->endDate(),
        'ranges' => [
            'Today',
            'Yesterday',
            'Last 7 Days',
            'Last 30 Days',
            'This Month',
            'Last Month',
            'This Year',
            'Last Year',
        ]
    ]) ?>
    <br>
    <?= Filter::widget([
        'data' => $modules,
        'title' => 'Module',
        'attribute' => 'modules',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Filter::widget([
        'data' => ActiveRecord::mapRecords(),
        'title' => 'Record Status',
        'attribute' => 'record_status',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Pagination::widget([
        'model' => $model,
        'form' => $form,
        'title' => 'Limit',
    ]) ?>
    <?= SearchButton::widget() ?>
<?php ActiveForm::end(); ?>