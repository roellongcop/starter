<?php

namespace tests\unit\models;

use app\models\VisitLog;

class VisitLogTest extends \Codeception\Test\Unit
{
    protected function data()
    {
        return [
            'user_id' => 1,
            'ip' => '::1',
            'action' => VisitLog::ACTION_LOGIN,
            'created_by' => 1,
            'updated_by' => 1, 
        ];
    }

    public function testCreateSuccess()
    {
        $model = new VisitLog($this->data());
        expect_that($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new VisitLog();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatusMustFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new VisitLog($data);
        expect_not($model->save());
    }

    public function testCreateInvalidActionMustFailed()
    {
        $data = $this->data();
        $data['action'] = 3;

        $model = new VisitLog($data);
        expect_not($model->save());
    }

    public function testCreateNotExisitngUserMustFailed()
    {
        $data = $this->data();
        $data['user_id'] = 10001;
        $model = new VisitLog($data);
        expect_not($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\VisitLog');
        expect_that($model->delete());
    }

    public function testActivateDataMustSuccess()
    {
        $model = $this->tester->grabRecord('app\models\VisitLog');
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataMustFailed()
    {
        $model = $this->tester->grabRecord('app\models\VisitLog');
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}