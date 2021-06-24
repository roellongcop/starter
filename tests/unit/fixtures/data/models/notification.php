<?php
use app\helpers\Url;
use app\models\Notification;

return [
	1 => [
		'user_id' => 1,
		'message' => 'You\'ve Change your password',
		'link' => Url::to(['user/my-password']),
		'type' => 'notification_change_password',
		'token' => 'TftF853osh1623298888',
		'status' => Notification::STATUS_UNREAD,
		'created_by' => 1,
		'updated_by' => 1,
	],
	2 => [
		'user_id' => 1,
		'message' => 'You\'ve Change your password',
		'link' => Url::to(['user/my-password']),
		'type' => 'notification_change_password',
		'token' => 'TftF853osh1623298888',
		'status' => Notification::STATUS_READ,
		'created_by' => 1,
		'updated_by' => 1,
	]
];