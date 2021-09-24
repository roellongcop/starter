<?php

use app\models\Visitor;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'expire' => time(),
		'cookie' => 'Cookie',
		'ip' => 'Ip',
		'browser' => 'Browser',
		'os' => 'Os',
		'device' => 'Device',
		'location' => 'Location',
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => Visitor::RECORD_INACTIVE
]);

return $model->getData();