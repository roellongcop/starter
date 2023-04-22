<?php

$params = require __DIR__ . '/params.php';

return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@consoleWebroot' => dirname(__DIR__) . '/web',
    ],
    'language' => 'en-US',
    'components' => [
        'imageResize' => ['class' => 'app\components\ImageResizeComponent'],
        'db' => ['class' => 'app\components\ConnectionComponent'],
        'queue' => [
            'class' => 'app\components\QueueComponent',
            'as log' => 'yii\queue\LogBehavior',
        ],
        'access' => ['class' => 'app\components\AccessComponent'],
        'setting' => ['class' => 'app\components\SettingComponent'],
        'general' => ['class' => 'app\components\GeneralComponent'],
        'formatter' => ['class' => 'app\components\FormatterComponent'],
        'view' => ['class' => 'app\components\ViewComponent'],
        'pdf' => ['class' => 'app\components\PdfComponent'],
        'session' => ['class' => 'app\components\DbSessionComponent'],
        'mailer' => ['class' => 'app\components\MailerComponent'],
        'urlManager' => ['class' => 'app\components\UrlManagerComponent'],
        'assetManager' => [
            'class' => 'app\components\AssetManagerComponent',
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'user' => [
            'class' => 'app\components\UserComponent',
            'enableSession' => false,
        ],
        'request' => [
            'class' => 'app\components\RequestComponent',
            'enableCsrfValidation' => false,
        ],
    ],
    'params' => $params,
];
