<?php

use app\models\Visitor;

$model = new \app\helpers\FixtureData(function($params) {
    return [
    	'session_id' => '1111',
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
	'session_id' => '2222222',
	'cookie' => 'cookie22222',
	'record_status' => Visitor::RECORD_INACTIVE
]);

return $model->getData();