<?php
use app\helpers\App;

$access = App::component('access');
$controllerActions = $access->controllerActions();
$defaultNavigation = $access->defaultNavigation();

return [
    'admin' => [
        'name' => 'admin', 
        'role_access' => json_encode([]),
    'module_access' => json_encode($controllerActions),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'admin', 
        'record_status' => 1,
    ],
    'superadmin' => [
        'name' => 'superadmin', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($controllerActions),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'superadmin', 
        'record_status' => 1,
    ],
    'developer' => [
        'name' => 'developer', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($controllerActions),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'developer', 
        'record_status' => 1,
    ],
    'inactiverole' => [
        'name' => 'inactiverole', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($controllerActions),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'inactiverole', 
        'record_status' => 0,
    ],
    'nouser' => [
        'name' => 'nouser', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($controllerActions),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'nouser', 
        'record_status' => 0,
    ]
];