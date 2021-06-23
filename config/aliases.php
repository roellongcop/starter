<?php

$alises = [
	'@uploads' => dirname(dirname(__DIR__)) . '/web/protected/uploads',
	'@backups' => dirname(dirname(__DIR__)) . '/web/protected/backups',
    '@export' => dirname(dirname(__DIR__)) . '/web/protected/exports',
];

foreach ($alises as $key => $value) {
	\Yii::setAlias($key, $value);
}
