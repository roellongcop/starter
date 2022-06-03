<?php

use app\models\UserMeta;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($name) {
    return [
        'user_id' => 1, 
        'name' => $name,
        'value' => json_encode([
            'user_id' => 1,
            'first_name' => 'admin_firstname',
            'last_name' => 'admin_lastname',
        ]),
        'record_status' => UserMeta::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
        'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('profile', 'profile');
$model->add('my-settings', 'my-settings', [
    'value' => json_encode([
        'user_id' => 1,
        'theme_id' => 1,
    ]),
]);
$model->add('inactive', 'inactive', [
    'record_status' => UserMeta::RECORD_INACTIVE,
]);

return $model->getData();