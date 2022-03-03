<?php

use app\models\VisitLog;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($action) {
    return [
		'user_id' => 1,
		'ip' => '::1',
		'action' => $action,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
		'created_by' => 1,
		'updated_by' => 1,
	];
});

$model->add('login', VisitLog::ACTION_LOGIN);
$model->add('logout', VisitLog::ACTION_LOGOUT);
$model->add('inactive', VisitLog::ACTION_LOGOUT, [
    'record_status' => VisitLog::RECORD_INACTIVE,
]);

return $model->getData();