<?php

namespace tests\unit\models;

use app\models\Session;

class SessionTest extends \Codeception\Test\Unit
{
    protected function data()
    {
        return [
            'id' => 'in2jfqrqoj5d6luo7qleggimid' . time(),
            'expire' => time(),
            'user_id' => 0,
            'ip' => '::1',
            'browser' => 'Chrome',
            'os' => 'Windows',
            'device' => 'Computer',
        ];
    }

    public function testCreateSuccess()
    {
        $model = new Session($this->data());
        expect_that($model->save());
    }

    public function testCreateNoData()
    {
        $model = new Session();
        expect_not($model->save());
    }

    public function testCreateInvalidIp()
    {
        $data = $this->data();
        $data['ip'] = 'invalidIP';

        $model = new Session($data);
        expect_not($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Session');
        expect_that($model->delete());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new Session($data);
        expect_not($model->save());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Session');
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Session');
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}