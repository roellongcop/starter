<?php

use app\models\Setting;
use yii\helpers\Inflector;

$model = new \app\helpers\FixtureData(function($name) {
    return [
		'name' => $name,
		'value' => 'Asia/Manila',
		'slug' => Inflector::slug($name),
		'type' => Setting::TYPE_INPUT,
		'sort_order' => 0,
		'created_by' => 1,
		'updated_by' => 1,
	];
});

$model->add('timezone', 'timezone');
$model->add('inactive', 'inactive', [
	'value' => 'inactive',
    'record_status' => Setting::RECORD_INACTIVE,
]);

return $model->getData();