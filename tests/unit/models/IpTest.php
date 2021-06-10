<?php
namespace tests\unit\models;

use app\models\Ip;

class IpTest extends \Codeception\Test\Unit
{
    public function testCreate()
    {
        $model = new Ip([
            'name' => '191.168.1.2',  
            'description' => 'test',  
            'type' => 1,   
            'record_status' => 1,  
        ]);

        expect_that($model->save());
    }

    public function testCreateNoData()
    {
        $model = new Ip([
            'record_status' => 1,  
        ]);

        expect_not($model->save());
    }

    public function testCreateNoIPName()
    {
        $model = new Ip([
            'description' => 'test',  
            'type' => 1,   
            'record_status' => 1,  
        ]);

        expect_not($model->save());
        expect($model->errors)->hasKey('name');
    }

    public function testCreateInvalidIPName()
    {
        $model = new Ip([
            'name' => 'not ip',  
            'description' => 'test',  
            'type' => 1,   
            'record_status' => 1,  
        ]);

        expect_not($model->save());
        expect($model->errors)->hasKey('name');
    }

    public function testUpdate()
    {
        $model = Ip::findOne(1);
        $model->record_status = 0;
        expect_that($model->save());
    }

    public function testDelete()
    {
        $model = Ip::findOne(1);
        expect_that($model->delete());
    }
}