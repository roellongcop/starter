<?php
use app\helpers\App;

$access = App::component('access');
$controllerActions = $access->controllerActions();
$defaultNavigation = $access->defaultNavigation();

$noiactiverole = $controllerActions;
$noiactiverole['role'] = [
    6 => 'change-record-status',
    7 => 'confirm-action',
    2 => 'create',
    5 => 'delete',
    3 => 'duplicate',
    10 => 'export-csv',
    9 => 'export-pdf',
    11 => 'export-xls',
    12 => 'export-xlsx',
    0 => 'index',
    13 => 'my-role',
    8 => 'print',
    4 => 'update',
    1 => 'view',
];

return [
    'developer' => [
        'name' => 'developer', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($controllerActions),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'developer', 
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
    'admin' => [
        'name' => 'admin', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($controllerActions),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'admin', 
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
    ],
    'developernoiactiverole' => [
        'name' => 'developernoiactiverole', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($noiactiverole),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'developernoiactiverole', 
        'record_status' => 0,
    ],
];