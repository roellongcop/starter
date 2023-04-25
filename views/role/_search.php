<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\RoleSearch */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'role-search-form'
]); ?>
    <?= $form->search($model) ?>
    <?= $form->dateRange($model) ?>
    <?= $form->recordStatusFilter($model) ?>
    <?= $form->pagination($model)  ?>
    <?= $form->searchButton()  ?>
<?php ActiveForm::end(); ?>