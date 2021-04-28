<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
        '@commands' => '@app/commands',
    ],
    'components' => [
        'setting' => ['class' => 'app\components\SettingComponent'],
        'access' => ['class' => 'app\components\AccessComponent'],
        'general' => ['class' => 'app\components\General'],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\User',
            'enableSession' => false,
            // 'enableAutoLogin' => true,
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
        'urlManager' => [
            'baseUrl' => '/starter/web'
        ]
    ],
    'params' => $params,
    'controllerMap' => [
        // 'fixture' => [ // Fixture generation command line.
        //     'class' => 'yii\faker\FixtureController',
        // ],
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            // 'migrationTable' => 'migrations',
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
