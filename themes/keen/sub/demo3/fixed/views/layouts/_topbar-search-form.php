<?php

use app\widgets\ActiveForm;
use app\widgets\Search;
?>
<?php $form = ActiveForm::begin(['action' => $searchAction, 'method' => 'get']); ?>
    <?= Search::widget([
        'model' => $searchModel,
        'style' => 'margin-top: 20px;'
    ]) ?>
<?php ActiveForm::end(); ?>