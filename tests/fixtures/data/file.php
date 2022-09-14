<?php

use app\models\File;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
        'name' => $params['name'] ?? 'default-image_200', 
        'tag' =>  $params['tag'] ?? 'Setting',
        'extension' => $params['extension'] ?? 'png',
        'size' => $params['size'] ?? 1606,
        'location' => $params['location'] ?? 'default/default-image_200.png',
        'token' => $params['token'] ?? 'token-default-image_200',
        'record_status' => File::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
        'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('profile', [
    'tag' => 'User'
]);

$model->add('backup', [
    'name' => 'default-backup', 
    'tag' => 'Sql',
    'extension' => 'sql',
    'size' => 81341,
    'location' => 'default/default-backup.sql',
    'token' => 'default-OxFBeC2Dzw1624513904-default',
]);

$model->add('inactive', ['name' => 'default-inactive'], [
    'record_status' => File::RECORD_INACTIVE,
    'token' => 'inactive-OxFBeC2Dzw1624513904-inactive',
]);

return $model->getData();