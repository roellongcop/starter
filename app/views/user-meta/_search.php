<?php

use app\helpers\App;
use app\widgets\DateRange;
use app\widgets\Filter;
use app\widgets\Pagination;
use app\widgets\Search;
use app\widgets\SearchButton;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\UserMetaSearch */
/* @var $form yii\widgets\ActiveForm */
?>
 

    <?php $form = ActiveForm::begin([
        'action' => $model->searchAction,
        'method' => 'get',
    ]); ?>

        <?= Search::widget(['model' => $model]) ?>
        
        <?= DateRange::widget(['model' => $model]) ?>
        
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
 
