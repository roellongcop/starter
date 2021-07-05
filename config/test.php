<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';
$pdf = require __DIR__ . '/pdf.php';
$queue = require __DIR__ . '/queue.php';

/**
 * Application configuration shared by all test types
 */
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
        'queue' => $queue,
        'file' => ['class' => 'app\components\FileComponent'],
        'export' => ['class' => 'app\components\ExportComponent'],
        'access' => ['class' => 'app\components\AccessComponent'],
        'setting' => ['class' => 'app\components\SettingComponent'],
        'general' => ['class' => 'app\components\GeneralComponent'],
        'formatter' => ['class' => 'app\components\FormatterComponent'],
        'db' => $db,
        'pdf' => $pdf,
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\User',
            'enableSession' => false,
            // 'enableAutoLogin' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
    'params' => $params,
];
