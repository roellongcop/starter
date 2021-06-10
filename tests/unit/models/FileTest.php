<?php
namespace tests\unit\models;

use app\models\File;

class FileTest extends \Codeception\Test\Unit
{
    public function testCreate()
    {
        $model = new File([
            'name' => 'test',  
            'extension' => 'png',  
            'size' => 123,  
            'location' => 'test_location',  
            'token' => 'test',  
            'record_status' => 1,  
        ]);

        expect_that($model->save());
    }


    public function testCreateInvalidExtension()
    {
        $model = new File([
            'name' => 'test',  
            'extension' => 'invalidext',  
            'size' => 123,  
            'location' => 'test_location',  
            'token' => 'test',  
            'record_status' => 1,  
        ]);

        expect_not($model->save());
        expect($model->errors)->hasKey('extension');
    }


    public function testUpdate()
    {
        $model = File::findOne(1);
        $model->record_status = 0;
        expect_that($model->save());
    }

    public function testDelete()
    {
        $model = File::findOne(1);
        expect_that($model->delete());
    }
}