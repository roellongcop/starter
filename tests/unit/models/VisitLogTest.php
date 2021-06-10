<?php
namespace tests\unit\models;

use app\models\VisitLog;

class VisitLogTest extends \Codeception\Test\Unit
{
    public function testCreateSuccess()
    {
        $model = new VisitLog([
            'user_id' => 1,
            'ip' => '::1',
            'action' => 0,
            'record_status' => 1,
            'created_by' => 1,
            'updated_by' => 1, 
        ]);

        expect_that($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new VisitLog([
            'record_status' => 1
        ]);
        expect_not($model->save());
    }

    public function testCreateNotExisitngUserMustFailed()
    {
        $model = new VisitLog([
            'user_id' => 10001,
            'ip' => '::1',
            'action' => 0,
            'record_status' => 1,
            'created_by' => 1,
            'updated_by' => 1, 
        ]);
        expect_not($model->save());
    }

    public function testUpdateSuccess()
    {
        $model = VisitLog::findOne(1);
        $model->record_status = 0;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = VisitLog::findOne(1);
        expect_that($model->delete());
    }
}