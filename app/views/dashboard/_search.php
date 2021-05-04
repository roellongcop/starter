<?php
use app\widgets\Filter;
use app\widgets\Pagination;
use app\widgets\Search;
use app\widgets\SearchButton;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form app\widgets\ActiveForm */

$modules = $model->loadModules();
$model->modules = $model->modules ?: array_keys($modules);
?>
    <?php $form = ActiveForm::begin([
        'action' => $model->searchAction,
        'method' => 'get',
        'options' => ['class' => 'kt-quick-search__form']
    ]); ?>

        <?= Search::widget(['model' => $model]) ?>
         
        <?= Filter::widget([
            'data' => $modules,
            'title' => 'Module',
            'attribute' => 'modules',
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
 
