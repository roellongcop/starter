<?php
use app\helpers\App;
use app\models\Role;

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
    'developernoiactiverole' => [
        'name' => 'developernoiactiverole', 
        'role_access' => json_encode([]),
        'module_access' => json_encode($noiactiverole),
        'main_navigation' => json_encode($defaultNavigation),
        'slug' => 'developernoiactiverole', 
    ],
];