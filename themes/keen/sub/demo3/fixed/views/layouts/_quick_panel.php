<?php

use app\helpers\App;
use app\helpers\Html;
?>

<?= Html::if($this->params['searchModel'] ?? false, 
    function($searchModel) {
        return $this->render('_quick_panel-content', [
            'searchModel' => $searchModel,
            'searchTemplate' => $searchModel->searchTemplate ?? implode('/', [
                App::controllerID(),
                '_search'
            ])
        ]);
    }
) ?>

