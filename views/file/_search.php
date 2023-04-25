<?php

use app\models\search\FileSearch;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\FileSearch */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'file-search-form'
]); ?>
    <?= $form->search($model) ?>
    <?= $form->dateRange($model) ?>
    <?= $form->filter($model, 'extension', FileSearch::filter('extension'), 'Extension') ?>
    <?= $form->recordStatusFilter($model) ?>
    <?= $form->pagination($model)  ?>
    <?= $form->searchButton()  ?> 
<?php ActiveForm::end(); ?>