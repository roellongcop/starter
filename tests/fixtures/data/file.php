<?php

use app\models\File;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
        'name' => $params['name'] ?? 'default-image_200', 
        'extension' => $params['extension'] ?? 'png',
        'size' => $params['size'] ?? 1606,
        'location' => $params['location'] ?? 'default/default-image_200.png',
        'token' => $params['token'] ?? 'default-6ccb4a66-0ca3-46c7-88dd-default',
        'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$model->add('profile');

$model->add('backup', [
    'name' => 'default-backup', 
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