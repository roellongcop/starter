<?php

use app\helpers\Html;
?>
<?= Html::ifElse(
    $dataProviders, 
    $this->render('_with-result', [
        'dataProviders' => $dataProviders,
        'searchModel' => $searchModel,
    ]),
    $this->render('_no-result', [
        'searchModel' => $searchModel,
    ]),
) ?>