<?php

use yii\helpers\Inflector;
use app\helpers\App;
use app\models\Role;

$model = new \app\helpers\FixtureData(function($name) {
    return [
        'name' => $name, 
        'role_access' => json_encode([]),
        'module_access' => json_encode(App::component('access')->controllerActions()),
        'main_navigation' => json_encode(App::component('access')->defaultNavigation()),
        'slug' => Inflector::slug($name), 
    ];
});

$no_inactive_data_access = [];
foreach (App::component('access')->controllerActions() as $controllerID => $actions) {
    foreach ($actions as $key => $action) {
        if ($action != 'in-active-data') {
            $no_inactive_data_access[$controllerID][] = $action;
        }

    }
}

$model->add('developer', 'developer');
$model->add('superadmin', 'superadmin');
$model->add('admin', 'admin');
$model->add('inactiverole', 'inactiverole', [
    'record_status' => Role::RECORD_INACTIVE,
]);
$model->add('nouser', 'nouser');
$model->add('no_inactive_data_access', 'no_inactive_data_access', [
    'module_access' => json_encode($no_inactive_data_access),
]);

return $model->getData();