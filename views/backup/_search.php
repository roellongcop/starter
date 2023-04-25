<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\BackupSearch */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'backup-search-form'
]); ?>
    <?= $form->search($model) ?>
    <?= $form->dateRange($model) ?>
    <?= $form->pagination($model)  ?>
    <?= $form->searchButton()  ?>
<?php ActiveForm::end(); ?>