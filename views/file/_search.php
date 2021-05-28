<?php

use app\helpers\App;
use app\models\search\FileSearch;
use app\widgets\DateRange;
use app\widgets\Filter;
use app\widgets\Pagination;
use app\widgets\Search;
use app\widgets\SearchButton;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\FileSearch */
/* @var $form app\widgets\ActiveForm */
?>
 

    <?php $form = ActiveForm::begin([
        'action' => $model->searchAction,
        'method' => 'get',
        'options' => ['class' => 'kt-quick-search__form']
    ]); ?>

        <?= Search::widget(['model' => $model]) ?>
        
        <?= DateRange::widget(['model' => $model]) ?>

        <?= Filter::widget([
            'data' => FileSearch::filter('extension'),
            'title' => 'Extension',
            'attribute' => 'extension',
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
 
