<?php

use app\helpers\App;
$controllerActions = App::component('access')->controllerActions;
$createNavigation = App::component('access')->defaultNavigation;

return [
    'name' => 'admin', 
    'role_access' => [],
    'module_access' => $controllerActions,
    'main_navigation' => $createNavigation,
    'slug' => 'admin', 
    'record_status' => 1,
];