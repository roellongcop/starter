<?php

use app\helpers\Html;
?>
<?= Html::ifElse($dataProviders,
    function($dataProviders) use($searchModel) {
        return $this->render('_with-result', [
            'dataProviders' => $dataProviders,
            'searchModel' => $searchModel,
        ]);
    },
    function($dataProviders) use($searchModel) {
        return $this->render('_no-result', [
            'searchModel' => $searchModel,
        ]);
    },
) ?>