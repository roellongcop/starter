<?php

use app\models\Visitor;
use yii\db\Expression;

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
		'record_status' => Visitor::RECORD_ACTIVE,
		'created_by' => 1,
	    'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'session_id' => '2222222',
	'cookie' => 'cookie22222',
	'record_status' => Visitor::RECORD_INACTIVE
]);

return $model->getData();