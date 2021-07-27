<?php

namespace tests\unit\models;

use app\models\Session;

class SessionTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'id' => 'in2jfqrqoj5d6luo7qleggimid' . time(),
            'expire' => time(),
            'user_id' => 0,
            'ip' => '::1',
            'browser' => 'Chrome',
            'os' => 'Windows',
            'device' => 'Computer',
            'record_status' => Session::RECORD_ACTIVE
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new Session($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => Session::RECORD_INACTIVE]);

        $model = new Session($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new Session();
        expect_not($model->save());
    }

    public function testCreateInvalidIp()
    {
        $data = $this->data(['ip' => 'invalidIP']);

        $model = new Session($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('ip');
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Session', [
            'record_status' => Session::RECORD_ACTIVE
        ]);
        expect_that($model->delete());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new Session($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Session', [
            'record_status' => Session::RECORD_INACTIVE
        ]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Session', [
            'record_status' => Session::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}