<?php

use app\models\Queue;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($channel) {
    return [
		'channel' => $channel,
		'job' => '',
		'pushed_at' => 1623377345,
		'ttr' => 300,
		'delay' => 0,
		'priority' => 1024,
		'reserved_at' => NULL,
		'attempt' => NULL,
		'done_at' => NULL,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
		'created_by' => 1,
		'updated_by' => 1,
	];
});

$model->add('default', 'default');
$model->add('inactive', 'default', [
    'record_status' => Queue::RECORD_INACTIVE,
]);

return $model->getData();