<?php

use app\helpers\App;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\IpSearch */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'ip-search-form'
]); ?>
    <?= $form->search($model) ?>
    <?= $form->dateRange($model) ?>
    <?= $form->filter($model, 'type', App::keyMapParams('ip_types')) ?>
    <?= $form->recordStatusFilter($model) ?>
    <?= $form->pagination($model)  ?>
    <?= $form->searchButton()  ?>
<?php ActiveForm::end(); ?>