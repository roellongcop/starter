<?php

use app\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['action' => $searchAction, 'method' => 'get']); ?>
    <?= $form->search($searchModel, [
        'submitOnclick' => true,
        'options' => ['style' => 'margin-top: 20px;']
    ]) ?>
<?php ActiveForm::end(); ?>