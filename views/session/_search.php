<?php

use app\models\search\SessionSearch;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\SessionSearch */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'session-search-form'
]); ?>
    <?= $form->search($model) ?>
    <?= $form->dateRange($model) ?>
    <?= $form->filter($model, 'browser', SessionSearch::filter('browser')) ?>
    <?= $form->filter($model, 'os', SessionSearch::filter('os')) ?>
    <?= $form->filter($model, 'device', SessionSearch::filter('device')) ?>
    <?= $form->recordStatusFilter($model) ?>
    <?= $form->pagination($model)  ?>
    <?= $form->searchButton()  ?>
<?php ActiveForm::end(); ?>