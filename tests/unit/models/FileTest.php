<?php

namespace tests\unit\models;

use app\helpers\App;
use app\models\File;

class FileTest extends \Codeception\Test\Unit
{
    protected function data()
    {
        return [
            'name' => 'default-image_200',  
            'extension' => 'png',  
            'size' => 1606,  
            'location' => 'default/default-image_200.png',  
            'token' => App::randomString(10) . time(),  
            'record_status' => 1,  
        ];
    }

    public function testCreateSuccess()
    {
        $model = new File($this->data());
        expect_that($model->save());
    }

    public function testCreateNoDataFailed()
    {
        $model = new File();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatusFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new File($data);
        expect_not($model->save());
    }

    public function testCreateInvalidExtensionFailed()
    {
        $data = $this->data();
        $data['extension'] = 'invalid_extension';

        $model = new File($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('extension');
    }

    public function testUpdateSuccess()
    {
        $model = File::findOne(1);
        $model->name = 'update';
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = File::findOne(1);
        expect_that($model->delete());
    }

    public function testActivateDataSuccess()
    {
        $model = File::findOne(1);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataFailed()
    {
        $model = File::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}