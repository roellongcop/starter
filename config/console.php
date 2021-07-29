<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$pdf = require __DIR__ . '/pdf.php';
$queue = require __DIR__ . '/queue.php';
$urlManager = require __DIR__ . '/urlManager.php';

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
        'queue' => $queue,
        'file' => ['class' => 'app\components\FileComponent'],
        'export' => ['class' => 'app\components\ExportComponent'],
        'setting' => ['class' => 'app\components\SettingComponent'],
        'access' => ['class' => 'app\components\AccessComponent'],
        'general' => ['class' => 'app\components\General'],
        'formatter' => ['class' => 'app\components\FormatterComponent'],
        'view' => ['class' => '\app\components\ViewComponent'],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\User',
            'enableSession' => false,
            // 'enableAutoLogin' => true,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'session' => [ // for use session in console application
            'class' => 'yii\web\Session'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'pdf' => $pdf,
        'urlManager' => $urlManager
    ],
    'params' => $params,
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            // 'class' => 'yii\faker\FixtureController',
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'app\tests\fixtures',
        ],
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationTable' => '{{%migrations}}',
            'generatorTemplateFiles' => [
                'create_table'    => '@app/migrations/templates/createTableMigration.php',
                'drop_table'      => '@app/migrations/templates/dropTableMigration.php',
                'add_column'      => '@app/migrations/templates/addColumnMigration.php',
                'drop_column'     => '@app/migrations/templates/dropColumnMigration.php',
                'create_junction' => '@app/migrations/templates/createTableMigration.php'
            ]
        ],
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
