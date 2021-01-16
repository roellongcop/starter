<?php

use app\helpers\App;
use app\models\search\LogSearch;
use app\widgets\DateRange;
use app\widgets\Filter;
use app\widgets\Pagination;
use app\widgets\Search;
use app\widgets\SearchButton;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\LogSearch */
/* @var $form yii\widgets\ActiveForm */
?>
 

    <?php $form = ActiveForm::begin([
        'action' => $model->searchAction,
        'method' => 'get',
        'options' => ['class' => 'kt-quick-search__form']
    ]); ?>

        <?= Search::widget(['model' => $model]) ?>
        
        <?= DateRange::widget(['model' => $model]) ?>

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
        
        <?= Filter::widget([
            'data' => App::mapParams('record_status'),
            'title' => 'Record Status',
            'attribute' => 'record_status',
            'model' => $model,
            'form' => $form,
        ]) ?>

        <?= Pagination::widget([
            'model' => $model,
            'form' => $form,
        ]) ?>

        <?= SearchButton::widget() ?>


    <?php ActiveForm::end(); ?>
 
