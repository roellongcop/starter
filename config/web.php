<?php

$db = require __DIR__ . '/db.php';
$pdf = require __DIR__ . '/pdf.php';
$params = require __DIR__ . '/params.php';
$session = require __DIR__ . '/session.php';
$queue = require __DIR__ . '/queue.php';
$urlManager = require __DIR__ . '/urlManager.php';

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
        'queue' => $queue,
        'setting' => ['class' => 'app\components\SettingComponent'],
        'access' => ['class' => 'app\components\AccessComponent'],
        'file' => ['class' => 'app\components\FileComponent'],
        'export' => ['class' => 'app\components\ExportComponent'],
        'general' => ['class' => 'app\components\GeneralComponent'],
        'formatter' => ['class' => 'app\components\FormatterComponent'],
        'view' => ['class' => '\app\components\ViewComponent'],

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'kACKH_pi2sZVSJRHwBQl6T-9zvnuM30L',
            'enableCsrfValidation' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'pdf' => $pdf,
        'session' => $session,
        'urlManager' => $urlManager,
        'assetManager' => [
            // 'forceCopy' => true,
            'linkAssets' => false,
            'class' => 'yii\web\AssetManager',
            'appendTimestamp' => true,
        ],
       // 'view' => [
       //      'theme' => [
       //          'basePath' => '@web/app/themes/keenDemo1/assets/assets/',
       //          'baseUrl' => '@web/app/themes/keenDemo1',
       //          'pathMap' => [
       //              '@app/views' => '@app/themes/keenDemo1/views',
       //              '@app/widgets' => '@app/themes/keenDemo1/widgets',
       //          ],
       //      ],
       //  ],
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
            // generator name
            'crud' => [
                // generator class
                'class' => 'app\gii\crud\starter\Generator',
                // 'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    // template name => path to template
                    'starter' => '@app/gii/crud/starter/default',
                ]
            ],
            'model' => [
                'class' => 'app\gii\model\starter\Generator',
                'templates' => [ 
                    'starter' => '@app/gii/model/starter/default', 
                ]
            ],
            'controller' => [
                'class' => 'yii\gii\generators\controller\Generator',
                'templates' => [ 
                    'api' => '@app/gii/controller/api/default', 
                ]
            ]
        ],
    ];
}

return $config;
