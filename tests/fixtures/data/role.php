<?php

use yii\helpers\Inflector;
use app\helpers\App;
use app\models\Role;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($name) {
    return [
        'name' => $name, 
        'role_access' => json_encode([]),
        'module_access' => json_encode(App::component('access')->controllerActions),
        'main_navigation' => json_encode(App::component('access')->defaultNavigation),
        'slug' => Inflector::slug($name), 
        'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$no_inactive_data_access = [];
foreach (App::component('access')->controllerActions as $controllerID => $actions) {
    foreach ($actions as $key => $action) {
        if ($action != 'in-active-data') {
            $no_inactive_data_access[$controllerID][] = $action;
        }

    }
}

$model->add('developer', 'developer', [
    'role_access' => json_encode([1,2,3])
]);
$model->add('superadmin', 'superadmin', [
    'role_access' => json_encode([2,3])
]);
$model->add('admin', 'admin', [
    'role_access' => json_encode([3])
]);
$model->add('inactiverole', 'inactiverole', [
    'record_status' => Role::RECORD_INACTIVE,
]);
$model->add('nouser', 'nouser');
$model->add('no_inactive_data_access', 'no_inactive_data_access', [
    'module_access' => json_encode($no_inactive_data_access),
]);

return $model->getData();