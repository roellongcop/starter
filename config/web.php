<?php

$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'yii2-basic-starter',
    'name' => 'Yii2 Basic Starter Template',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\ApiModule',
        ],
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
        'view' => ['class' => 'app\components\ViewComponent'],
        'session' => ['class' => 'app\components\DbSessionComponent'],
        'user' => ['class' => 'app\components\UserComponent'],
        'urlManager' => ['class' => 'app\components\UrlManagerComponent'],
        'pdf' => ['class' => 'app\components\PdfComponent'],
        'request' => ['class' => 'app\components\RequestComponent'],
        'cache' => ['class' => 'yii\caching\FileCache'],
        'mailer' => ['class' => 'app\components\MailerComponent'],
        'assetManager' => ['class' => 'app\components\AssetManagerComponent'],
        'errorHandler' => ['errorAction' => 'site/error'],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],

        'generators' => [
            'crud' => [
                'class' => 'app\gii\crud\starter\Generator',
                'templates' => [
                    'starter' => '@app/gii/crud/starter/default',
                    'default' => '@vendor/yiisoft/yii2-gii/src/generators/crud/default'
                ]
            ],
            'model' => [
                'class' => 'app\gii\model\starter\Generator',
                'templates' => [ 
                    'starter' => '@app/gii/model/starter/default', 
                    'default' => '@vendor/yiisoft/yii2-gii/src/generators/model/default'
                ]
            ],
        ],
    ];
}

return $config;
