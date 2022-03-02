<?php

use app\models\Session;

$model = new \app\helpers\FixtureData(function($id) {
    return [
		'id' => $id,
		'expire' => time(),
		'data' => '',
		'user_id' => 1,
		'ip' => '::1',
		'browser' => 'Chrome',
		'os' => 'Windows',
		'device' => 'Computer',
		'created_by' => 1,
		'updated_by' => 1,
	];
});

$model->add('1', 'id1');
$model->add('2', 'id2');
$model->add('inactive', 'id3', [
    'record_status' => Session::RECORD_INACTIVE,
]);

return $model->getData();