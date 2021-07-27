<?php

namespace tests\unit\models;

use app\models\VisitLog;

class VisitLogTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'user_id' => 1,
            'ip' => '::1',
            'action' => VisitLog::ACTION_LOGIN,
            'created_by' => 1,
            'updated_by' => 1,
            'record_status' => VisitLog::RECORD_ACTIVE
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new VisitLog($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => VisitLog::RECORD_INACTIVE]);

        $model = new VisitLog($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new VisitLog();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new VisitLog($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testCreateInvalidAction()
    {
        $data = $this->data(['action' => 3]);

        $model = new VisitLog($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('action');
    }

    public function testCreateNotExisitngUser()
    {
        $data = $this->data(['user_id' => 10001]);
        $model = new VisitLog($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\VisitLog', [
            'record_status' => VisitLog::RECORD_ACTIVE
        ]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\VisitLog', [
            'record_status' => VisitLog::RECORD_INACTIVE
        ]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\VisitLog', [
            'record_status' => VisitLog::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}