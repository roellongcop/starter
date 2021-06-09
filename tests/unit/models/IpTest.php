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