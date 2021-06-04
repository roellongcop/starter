<?php
use app\helpers\App;
$access = App::component('access');
$controllerActions = $access->controllerActions();
$defaultNavigation = $access->defaultNavigation();


return [
    'profile' => [
        'user_id' => 3, 
        'meta_key' => 'profile',
        'meta_value' => json_encode([
            'user_id' => 3,
            'first_name' => 'developer_firstname',
            'last_name' => 'developer_lastname',
        ]),
        'record_status' => 1,
    ],
];