<?php

use app\models\search\LogSearch;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\LogSearch */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'log-search-form',
    'fieldConfig' => [
        'labelOptions' => ['class' => 'control-label font-weight-bold'],
    ],
]); ?>
    <?= $form->search($model) ?>
    <?= $form->dateRange($model) ?>
    <br>
    <?= $form->field($model, 'model_id')->textInput(['name' => 'model_id']) ?>
    <?= $form->filter($model, 'method', LogSearch::filter('method')) ?>
    <?= $form->filter($model, 'action', LogSearch::filter('action')) ?>
    <?= $form->filter($model, 'controller', LogSearch::filter('controller')) ?>
    <?= $form->filter($model, 'table_name', LogSearch::filter('table_name')) ?>
    <?= $form->filter($model, 'model_name', LogSearch::filter('model_name')) ?>
    <?= $form->filter($model, 'browser', LogSearch::filter('browser')) ?>
    <?= $form->filter($model, 'os', LogSearch::filter('os')) ?>
    <?= $form->filter($model, 'device', LogSearch::filter('device')) ?>
    <?= $form->recordStatusFilter($model) ?>
    <?= $form->pagination($model)  ?>
    <?= $form->searchButton()  ?>
<?php ActiveForm::end(); ?>