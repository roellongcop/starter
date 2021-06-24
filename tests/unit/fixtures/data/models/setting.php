<?php
use app\models\Setting;
use yii\helpers\Inflector;

return [
	'timezone' => [
		'name' => 'timezone',
		'value' => 'Asia/Manila',
		'slug' => Inflector::slug('timezone'),
		'type' => Setting::TYPE_GENERAL,
		'sort_order' => 0,
		'created_by' => 1,
		'updated_by' => 1,
	],
];