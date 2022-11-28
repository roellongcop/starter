<?php

$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
        '@commands' => '@app/commands',
        '@consoleWebroot' => dirname(__DIR__) . '/web',
    ],
    'components' => [
        'imageResize' => ['class' => 'app\components\ImageResizeComponent'],
        'db' => ['class' => 'app\components\ConnectionComponent'],
        'queue' => [
            'class' => 'app\components\QueueComponent',
            'as log' => 'yii\queue\LogBehavior',
        ],
        'setting' => ['class' => 'app\components\SettingComponent'],
        'access' => ['class' => 'app\components\AccessComponent'],
        'general' => ['class' => 'app\components\GeneralComponent'],
        'formatter' => ['class' => 'app\components\FormatterComponent'],
        'urlManager' => [
            'class' => 'app\components\UrlManagerComponent',
            'scriptUrl' => '/',
            'baseUrl' => '/',
            'hostInfo' => '/',
        ],
        'session' => ['class' => 'app\components\DbSessionComponent'],
        'pdf' => ['class' => '\app\components\PdfComponent'],
        'mailer' => ['class' => '\app\components\MailerComponent'],
        'user' => [
            'class' => 'app\components\UserComponent',
            'enableSession' => false,
        ],
        'assetManager' => [
            'class' => 'app\components\AssetManagerComponent',
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'cache' => ['class' => 'yii\caching\FileCache'],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
    'controllerMap' => [
        'fixture' => ['class' => 'app\components\FixtureControllerComponent'],
        'migrate' => ['class' => 'app\components\MigrateControllerComponent'],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
