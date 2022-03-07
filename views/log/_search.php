<?php

use app\models\search\LogSearch;
use app\widgets\ActiveForm;
use app\widgets\DateRange;
use app\widgets\Filter;
use app\widgets\Pagination;
use app\widgets\RecordStatusFilter;
use app\widgets\Search;
use app\widgets\SearchButton;

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
    <?= Search::widget(['model' => $model]) ?>
    <?= DateRange::widget(['model' => $model]) ?>
    <br>
    <?= $form->field($model, 'model_id')->textInput([
        'name' => 'model_id',
    ]) ?>
    <?= Filter::widget([
        'data' => LogSearch::filter('method'),
        'title' => 'Method',
        'attribute' => 'method',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Filter::widget([
        'data' => LogSearch::filter('action'),
        'title' => 'Action',
        'attribute' => 'action',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Filter::widget([
        'data' => LogSearch::filter('controller'),
        'title' => 'Controller',
        'attribute' => 'controller',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Filter::widget([
        'data' => LogSearch::filter('table_name'),
        'title' => 'Table Name',
        'attribute' => 'table_name',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Filter::widget([
        'data' => LogSearch::filter('model_name'),
        'title' => 'Model Name',
        'attribute' => 'model_name',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Filter::widget([
        'data' => LogSearch::filter('browser'),
        'title' => 'Browser',
        'attribute' => 'browser',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Filter::widget([
        'data' => LogSearch::filter('os'),
        'title' => 'OS',
        'attribute' => 'os',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Filter::widget([
        'data' => LogSearch::filter('device'),
        'title' => 'Device',
        'attribute' => 'device',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= RecordStatusFilter::widget([
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Pagination::widget([
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= SearchButton::widget() ?>
<?php ActiveForm::end(); ?>