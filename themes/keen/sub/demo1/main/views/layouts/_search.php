<?php

use app\helpers\App;
use app\helpers\Html;
?>

<?= Html::if($this->params['searchModel'] ?? false, 
    function($searchModel) {
        return $this->render('_search-content', [
            'searchModel' => $searchModel,
            'searchTemplate' => $searchModel->searchTemplate ?? implode('/', [
                App::controllerID(),
                '_search'
            ])
        ]);
    }
) ?>
