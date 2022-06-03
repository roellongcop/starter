<?php

use app\models\Setting;
use yii\helpers\Inflector;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($name) {
    return [
		'name' => $name,
		'value' => 'Asia/Manila',
		'slug' => Inflector::slug($name),
		'type' => Setting::TYPE_INPUT,
		'sort_order' => 0,
		'record_status' => Setting::RECORD_ACTIVE,
		'created_by' => 1,
	    'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
	];
});

$model->add('timezone', 'timezone');
$model->add('inactive', 'inactive', [
	'value' => 'inactive',
    'record_status' => Setting::RECORD_INACTIVE,
]);

return $model->getData();