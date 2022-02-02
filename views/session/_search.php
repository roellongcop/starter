<?php

use app\models\search\SessionSearch;
use app\widgets\ActiveForm;
use app\widgets\DateRange;
use app\widgets\Filter;
use app\widgets\Pagination;
use app\widgets\RecordStatusFilter;
use app\widgets\Search;
use app\widgets\SearchButton;

/* @var $this yii\web\View */
/* @var $model app\models\search\SessionSearch */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'session-search-form'
]); ?>
    <?= Search::widget(['model' => $model]) ?>
    <?= DateRange::widget(['model' => $model]) ?>
    <?= Filter::widget([
        'data' => SessionSearch::filter('browser'),
        'title' => 'Browser',
        'attribute' => 'browser',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Filter::widget([
        'data' => SessionSearch::filter('os'),
        'title' => 'OS',
        'attribute' => 'os',
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Filter::widget([
        'data' => SessionSearch::filter('device'),
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