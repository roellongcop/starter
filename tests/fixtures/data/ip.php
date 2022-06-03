<?php

use app\models\Ip;
use yii\helpers\Inflector;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($name) {
    return [
        'name' => $name, 
        'description' => 'testing IP',
        'type' => Ip::TYPE_WHITELIST,
        'slug' => Inflector::slug($name),
        'record_status' => Ip::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
        'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('whitelist', '191.168.1.1');
$model->add('blacklist', '191.168.1.2', [
    'type' => Ip::TYPE_BLACKLIST,
]);
$model->add('inactive', '191.168.1.9', [
    'record_status' => Ip::RECORD_INACTIVE,
]);

return $model->getData();