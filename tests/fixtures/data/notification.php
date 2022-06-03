<?php

use app\helpers\Url;
use app\models\Notification;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($type) {
    return [
		'user_id' => 1,
		'message' => 'You\'ve Change your password',
		'link' => '/my-password',
		'type' => $type,
		'token' => 'TftF853osh1623298888',
		'status' => Notification::STATUS_UNREAD,
		'record_status' => Notification::RECORD_ACTIVE,
		'created_by' => 1,
	    'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
	];
});
$model->add('unread', 'notification_change_password');
$model->add('read', 'notification_change_password', [
	'token' => 'readTftF853osh1623298881',
	'status' => Notification::STATUS_READ,
]);
$model->add('inactive', 'notification_change_password', [
	'token' => 'readTftF853osh1623298882',
	'record_status' => Notification::RECORD_INACTIVE,
]);

return $model->getData();