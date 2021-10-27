<?php

use app\helpers\App;
use app\helpers\Html;

$searchModel = $this->params['searchModel'] ?? '';
$searchTemplate = $searchModel->searchTemplate ?? App::controllerID() . '/_search';
?>
<?= Html::if($searchModel, $this->render('_quick_panel_canvas-content', [
    'searchModel' => $searchModel,
    'searchTemplate' => $searchTemplate,
])) ?>