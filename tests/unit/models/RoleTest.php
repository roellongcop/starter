<?php
namespace tests\unit\models;

use app\helpers\App;
use app\models\Role;

class RoleTest extends \Codeception\Test\Unit
{
    public $controllerActions;
    public $defaultNavigation;

    protected function _before()
    {
        $access = App::component('access');
        $this->controllerActions = $access->controllerActions();
        $this->defaultNavigation = $access->defaultNavigation();
    }

    public function testCreateSuccess()
    {
        $model = new Role([
            'name' => 'testrole', 
            'role_access' => json_encode([]),
            'module_access' => json_encode($this->controllerActions),
            'main_navigation' => json_encode($this->defaultNavigation),
            'slug' => 'admin', 
            'record_status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        expect_that($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new Role([
            'record_status' => 1
        ]);
        expect_not($model->save());
    }

    public function testUpdateSuccess()
    {
        $model = Role::findOne(1);
        $model->record_status = 0;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = Role::findOne(['name' => 'nouser']);
        expect_that($model->delete());
    }

    public function testDeleteWithRelatedUserMustFailed()
    {
        $model = Role::findOne(['name' => 'developer']);
        expect_not($model->delete());
    }
}