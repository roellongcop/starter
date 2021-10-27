<?php

use app\widgets\ActiveForm;
use app\widgets\Search;
?>
<?php $form = ActiveForm::begin([
    'id' => 'main-search-form',
    'action' => $searchAction, 
    'method' => 'get'
]); ?>
    <?= Search::widget([
        'model' => $searchModel,
        'style' => 'margin-top: 17px;width: 30vw;margin-left: 10px;'
    ]) ?>
<?php ActiveForm::end(); ?>