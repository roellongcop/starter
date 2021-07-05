<?php

use app\models\UserMeta;

$model = new \app\helpers\FixtureData(function($meta_key) {
    return [
        'user_id' => 1, 
        'meta_key' => $meta_key,
        'meta_value' => json_encode([
            'user_id' => 1,
            'first_name' => 'admin_firstname',
            'last_name' => 'admin_lastname',
        ]),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$model->add('profile', 'profile');
$model->add('inactive', 'inactive', [
    'record_status' => UserMeta::RECORD_INACTIVE,
]);

return $model->getData();