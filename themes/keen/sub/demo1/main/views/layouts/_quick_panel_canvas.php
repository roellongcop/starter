<?php

use app\helpers\App;
use app\helpers\Html;
?>

<?= Html::if(($searchModel = $this->params['searchModel'] ?? '') != NULL, 
    function() use($searchModel) {
        return $this->render('_quick_panel_canvas-content', [
            'searchModel' => $searchModel,
            'searchTemplate' => $searchModel->searchTemplate ?? implode('/', [
                App::controllerID(),
                '_search'
            ])
        ]);
    }
) ?>