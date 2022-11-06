<?php

use app\helpers\App;
use app\helpers\Html;

$searchModel = $this->params['searchModel'] ?? '';
?>

<?= Html::if($searchModel, 
	function($searchModel) {
		return $this->render('_search-content', [
			'searchModel' => $searchModel,
			'searchTemplate' => $searchModel->searchTemplate ?? '/' . implode('/', [
				App::controllerID(),
				'_search'
			]),
			'searchAction' => $searchModel->searchAction ?? ['index'],
		]);
	}
) ?>
