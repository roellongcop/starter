<?php
namespace tests\unit\models;

use app\models\ModelFile;

class ModelFileTest extends \Codeception\Test\Unit
{
    public function testCreateSuccess()
    {
        $model = new ModelFile([
            'model_id' => 1,  
            'file_id' => 1,  
            'model_name' => 'User',  
            'extension' => 'png',  
            'record_status' => 1,  
        ]);

        expect_that($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new ModelFile([
            'record_status' => 1,  
        ]);

        expect_not($model->save());
    }

    public function testCreateInvalidFileIdMustFailed()
    {
        $model = new ModelFile([
            'model_id' => 1,  
            'file_id' => 100001,  
            'model_name' => 'User',  
            'extension' => 'png',  
            'record_status' => 1,  
        ]);

        expect_not($model->save());
        expect($model->errors)->hasKey('file_id');
    }


    public function testCreateInvalidModelIdMustFailed()
    {
        $model = new ModelFile([
            'model_id' => 100001,  
            'file_id' => 1,  
            'model_name' => 'User',  
            'extension' => 'png',  
            'record_status' => 1,  
        ]);

        expect_not($model->save());
        expect($model->errors)->hasKey('model_id');
    }

    public function testUpdateSuccess()
    {
        $model = ModelFile::findOne(1);
        $model->record_status = 0;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = ModelFile::findOne(1);
        expect_that($model->delete());
    }
}