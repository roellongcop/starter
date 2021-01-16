<?php

use app\helpers\App;
use kartik\mpdf\Pdf;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';


$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
   
    'components' => [
        
        'access' => ['class' => 'app\components\AccessComponent'],
        'logbook' => ['class' => 'app\components\LogBookComponent'],
        'file' => ['class' => 'app\components\FileComponent'],
        'export' => ['class' => 'app\components\ExportComponent'],
        'general' => ['class' => 'app\components\GeneralComponent'],
        'formatter' => ['class' => 'app\components\FormatterComponent'],

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
        'pdf' => [
            'class' => Pdf::classname(),
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // 'destination' => Pdf::DEST_BROWSER,
            'destination' => Pdf::DEST_DOWNLOAD,

            'cssInline' => '
                table, span, span.btn-font-sm {
                    font-size:10px !important;
                },
                th {
                    text-transform: uppercase !important;
                } 
                .mx40 {
                    max-width: 40px;
                } 
            ', 
            // refer settings section for all configuration options
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'my-role' => 'role/my-role',
                'my-account' => 'user/my-account',
                '<action:index|login|reset-password>' => 'site/<action>',
                '<controller>' => '<controller>/index',
                '<controller>/<id:\d+>' => '<controller>/view',
                '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
                '<controller>/<action>' => '<controller>/<action>', 
            ],
        ],
        'assetManager' => [
            // 'forceCopy' => true,
            'linkAssets' => false,
            'class' => 'yii\web\AssetManager',
        ],
        'session' => [
            'class'         => 'yii\web\DbSession',
            'sessionTable' => '{{%sessions}}',
            // 'timeout' => 1440,
            'writeCallback' => function ($session) { 
                return [
                    'user_id' => App::user('id'),
                    'ip' => App::ip(),
                    'browser' => App::browser(),
                    'os' => App::os(),
                    'device' => App::device(),
                    'created_at' => App::timestamp(),
                    'updated_at' => App::timestamp(),
               ];
            }
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
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    // template name => path to template
                    'starter' => '@app/gii/starter/crud/default',
                    'keenDemo1' => '@app/gii/keenDemo1/crud/default',
                    'keenDemo2' => '@app/gii/keenDemo2/crud/default',
                ]
            ],
            'model' => [
                'class' => 'yii\gii\generators\model\Generator',
                'templates' => [ 
                    'custom' => '@app/gii/custom/model/default', 
                ]
            ]
        ],
    ];
}

return $config;
