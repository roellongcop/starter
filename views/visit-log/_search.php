<?php

use app\helpers\App;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\VisitLogSearch */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'visit-log-search-form'
]); ?>
    <?= $form->search($model) ?>
    <?= $form->dateRange($model) ?>
    <?= $form->filter($model, 'action', App::keyMapParams('visit_log_actions')) ?>
    <?= $form->recordStatusFilter($model) ?>
    <?= $form->pagination($model)  ?>
    <?= $form->searchButton()  ?>
<?php ActiveForm::end(); ?>