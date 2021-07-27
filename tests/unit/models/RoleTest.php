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
        $this->controllerActions = $access->controllerActions;
        $this->defaultNavigation = $access->defaultNavigation;
    }

    protected function data($replace=[])
    {
        return array_replace([
            'name' => 'testrole', 
            'role_access' => [],
            'module_access' => $this->controllerActions,
            'main_navigation' => $this->defaultNavigation,
            'slug' => 'admin', 
            'record_status' => Role::RECORD_ACTIVE,
        ], $replace);
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => Role::RECORD_INACTIVE]);

        $model = new Role($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateSuccess()
    {
        $model = new Role($this->data());
        expect_that($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new Role($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testCreateNoData()
    {
        $model = new Role();
        expect_not($model->save());
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Role', [
            'record_status' => Role::RECORD_ACTIVE
        ]);
        $model->name = 'updated';
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Role', ['name' => 'nouser']);
        expect_that($model->delete());
    }

    public function testDeleteWithRelatedUser()
    {
        $model = $this->tester->grabRecord('app\models\Role', ['name' => 'developer']);
        expect_not($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Role', [
            'record_status' => Role::RECORD_INACTIVE
        ]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Role', [
            'record_status' => Role::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}