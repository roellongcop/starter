<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$pdf     = require __DIR__ . '/pdf.php';

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
    ],
    'components' => [
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config 
            'tableName' => '{{%queues}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex that used to sync queries
            'as log' => \yii\queue\LogBehavior::class,
            'ttr' => 5 * 60, // Max time for job execution
            'attempts' => 3, // Max number of attempts
        ],
        'export' => ['class' => 'app\components\ExportComponent'],
        'setting' => ['class' => 'app\components\SettingComponent'],
        'access' => ['class' => 'app\components\AccessComponent'],
        'general' => ['class' => 'app\components\General'],
        'formatter' => ['class' => 'app\components\FormatterComponent'],
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
        'urlManager' => [
            'scriptUrl' => 'http://localhost:8080',
            'baseUrl' => '/',
            'enablePrettyUrl' => true,
        ]
    ],
    'params' => $params,
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            // 'class' => 'yii\faker\FixtureController',
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'app\tests\unit\fixtures',
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
