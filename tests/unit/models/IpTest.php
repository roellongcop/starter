<?php

namespace tests\unit\models;

use app\models\Ip;

class IpTest extends \Codeception\Test\Unit
{
    protected function data()
    {
        return [
            'name' => '191.168.1.3',  
            'description' => 'test',  
            'type' => Ip::TYPE_WHITELIST,   
        ];
    }

    public function testCreateSuccess()
    {
        $model = new Ip($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data();
        $data['record_status'] = Ip::RECORD_INACTIVE;

        $model = new Ip($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new Ip($data);
        expect_not($model->save());
    }

    public function testCreateInvalidType()
    {
        $data = $this->data();
        $data['type'] = 10;

        $model = new Ip($data);
        expect_not($model->save());
    }

    public function testCreateNoData()
    {
        $model = new Ip();

        expect_not($model->save());
    }

    public function testCreateNoIPName()
    {
        $data = $this->data();
        unset($data['name']);
        $model = new Ip($data);

        expect_not($model->save());
        expect($model->errors)->hasKey('name');
    }

    public function testCreateInvalidIPName()
    {
        $data = $this->data();
        $data['name'] = 'invalidIP';
        $model = new Ip($data);

        expect_not($model->save());
        expect($model->errors)->hasKey('name');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Ip');
        $model->description = 'updated';
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Ip');
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Ip');
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Ip');
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}