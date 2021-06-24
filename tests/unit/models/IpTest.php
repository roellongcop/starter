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

    public function testCreateInvalidRecordStatusMustFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new Ip($data);
        expect_not($model->save());
    }

    public function testCreateInvalidTypeMustFailed()
    {
        $data = $this->data();
        $data['type'] = 10;

        $model = new Ip($data);
        expect_not($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new Ip();

        expect_not($model->save());
    }

    public function testCreateNoIPNameMustFailed()
    {
        $data = $this->data();
        unset($data['name']);
        $model = new Ip($data);

        expect_not($model->save());
        expect($model->errors)->hasKey('name');
    }

    public function testCreateInvalidIPNameMustFailed()
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

    public function testActivateDataMustSuccess()
    {
        $model = Ip::findOne(1);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataMustFailed()
    {
        $model = Ip::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}