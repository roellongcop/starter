<?php

namespace tests\unit\models;

use app\models\Ip;

class IpTest extends \Codeception\Test\Unit
{
    protected function data()
    {
        return [
            'name' => '191.168.1.2',  
            'description' => 'test',  
            'type' => 1,   
            'record_status' => 1,  
        ];
    }

    public function testCreateSuccess()
    {
        $model = new Ip($this->data());

        expect_that($model->save());
    }

    public function testCreateInvalidRecordStatusFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new Ip($data);
        expect_not($model->save());
    }

    public function testCreateNoDataFailed()
    {
        $model = new Ip();

        expect_not($model->save());
    }

    public function testCreateNoIPNameFailed()
    {
        $data = $this->data();
        unset($data['name']);
        $model = new Ip($data);

        expect_not($model->save());
        expect($model->errors)->hasKey('name');
    }

    public function testCreateInvalidIPNameFailed()
    {
        $data = $this->data();
        $data['name'] = 'invalidIP';
        $model = new Ip($data);

        expect_not($model->save());
        expect($model->errors)->hasKey('name');
    }

    public function testUpdateSuccess()
    {
        $model = Ip::findOne(1);
        $model->description = 'updated';
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = Ip::findOne(1);
        expect_that($model->delete());
    }

    public function testActivateDataSuccess()
    {
        $model = Ip::findOne(1);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataFailed()
    {
        $model = Ip::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}