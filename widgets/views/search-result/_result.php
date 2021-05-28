<?php

use app\helpers\App;
use app\widgets\Anchor;
use app\widgets\Detail;
use yii\helpers\Inflector;
use yii\widgets\ListView;
$moduleName = Inflector::pluralize($nameModule);
?>
<hr>
<p class="lead">
	<?= $moduleName ?> 
	(<?= number_format($dataProvider->totalCount) ?>)

	&nbsp;
	<?= Anchor::widget([
		'title' => 'View in ' . $moduleName . ' Page',
		'link' => ["{$controller}/index", 'keywords' => $searchModel->keywords],
		'options' => ['class' => 'btn btn-success btn-sm']
	]) ?>
</p>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'class' => 'accordion accordion-light accordion-toggle-arrow',
        'id' => $module,
    ],
    'layout' => "{summary}\n{items}",
    'itemView' => '_list',
    'viewParams' => [
    	'module' => $module
    ]
]); ?>
 