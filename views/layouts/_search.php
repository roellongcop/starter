<?php

use app\helpers\App;
use app\helpers\Html;

$searchModel = $this->params['searchModel'] ?? '';
$searchTemplate = $searchModel->searchTemplate ?? "/".App::controllerID()."/_search";
$searchAction = $searchModel->searchAction ?? ['index'];
?>

<?= Html::if($searchModel, $this->render('_search-content', [
	'searchModel' => $searchModel,
	'searchTemplate' => $searchTemplate,
	'searchAction' => $searchAction,
])) ?>
