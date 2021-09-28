<?php

namespace tests\unit\models;

use app\models\Visitor;

class VisitorTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'session_id' => '1234569',
            'expire' => time(),
            'cookie' => 'Cookiesample',
            'ip' => '191.168.1.1',
            'browser' => 'Browser',
            'os' => 'Os',
            'device' => 'Device',
            'location' => 'Location',
            'record_status' => Visitor::RECORD_ACTIVE
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new Visitor($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data();

        $model = new Visitor($data);
        $model->record_status = 3;
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }


    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data();

        $model = new Visitor($data);
        $model->record_status = 3;
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Visitor', [
            'record_status' => Visitor::RECORD_ACTIVE
        ]);
        $model->record_status = 1;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Visitor', [
            'record_status' => Visitor::RECORD_ACTIVE
        ]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Visitor', [
            'record_status' => Visitor::RECORD_INACTIVE
        ]);
        expect_that($model);

        $model->activate();

        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Visitor', [
            'record_status' => Visitor::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}