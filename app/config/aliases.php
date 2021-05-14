<?php
use Yii;

$alises = [
	'@uploads' => dirname(dirname(__DIR__)) . '/web/protected/uploads',
	'@backups' => dirname(dirname(__DIR__)) . '/web/protected/backups',
];

foreach ($alises as $key => $value) {
	Yii::setAlias($key, $value);
}
