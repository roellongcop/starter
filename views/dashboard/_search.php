<?php

use app\helpers\App;
use app\widgets\ActiveForm;

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
    <?= $form->search($model) ?>
    <?= $form->dateRange($model, [
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
    <?= $form->filter($model, 'modules', $modules, 'Module') ?>
    <?= $form->recordStatusFilter($model) ?>
    <?= $form->pagination($model, ['title' => 'Limit']) ?>
    <?= $form->searchButton()  ?>
<?php ActiveForm::end(); ?>