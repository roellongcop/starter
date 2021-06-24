<?php
use app\helpers\App;
use app\models\Role;

$access = App::component('access');
$controllerActions = $access->controllerActions();
$defaultNavigation = $access->defaultNavigation();

$no_inactive_data_access = [];

foreach ($controllerActions as $controllerID => $actions) {
    foreach ($actions as $key => $action) {
        if ($action == 'in-active-data') {
            continue;
        }

        $no_inactive_data_access[$controllerID][] = $action;
    }
}
return [
    'developer' => [
        'name' => 'developer', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($controllerActions),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'developer', 
    ],
    'superadmin' => [
        'name' => 'superadmin', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($controllerActions),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'superadmin', 
    ],
    'admin' => [
        'name' => 'admin', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($controllerActions),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'admin', 
    ],
    'inactiverole' => [
        'name' => 'inactiverole', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($controllerActions),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'inactiverole', 
        'record_status' => Role::RECORD_INACTIVE,
    ],
    'nouser' => [
        'name' => 'nouser', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($controllerActions),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'nouser', 
    ],
    'no_inactive_data_access' => [
        'name' => 'no_inactive_data_access', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($no_inactive_data_access),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'no_inactive_data_access', 
    ],
];