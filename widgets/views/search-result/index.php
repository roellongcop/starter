<?php

use app\helpers\Html;
?>
<?= Html::ifElse($dataProviders,
    function() use($dataProviders, $searchModel) {
        return $this->render('_with-result', [
            'dataProviders' => $dataProviders,
            'searchModel' => $searchModel,
        ]);
    },
    function() use($searchModel) {
        return $this->render('_no-result', [
            'searchModel' => $searchModel,
        ]);
    },
) ?>