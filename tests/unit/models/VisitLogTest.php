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
            'action' => 0,
            'record_status' => 1,
            'created_by' => 1,
            'updated_by' => 1, 
        ];
    }

    public function testCreateSuccess()
    {
        $model = new VisitLog($this->data());
        expect_that($model->save());
    }

    public function testCreateNoDataFailed()
    {
        $model = new VisitLog();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatusFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new VisitLog($data);
        expect_not($model->save());
    }

    public function testCreateNotExisitngUserFailed()
    {
        $data = $this->data();
        $data['user_id'] = 10001;
        $model = new VisitLog($data);
        expect_not($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = VisitLog::findOne(1);
        expect_that($model->delete());
    }

    public function testActivateDataSuccess()
    {
        $model = VisitLog::findOne(1);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataFailed()
    {
        $model = VisitLog::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}