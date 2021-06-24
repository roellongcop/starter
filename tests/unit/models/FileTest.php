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
        ];
    }

    public function testCreateSuccess()
    {
        $model = new File($this->data());
        expect_that($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new File();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatusMustFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new File($data);
        expect_not($model->save());
    }

    public function testCreateInvalidExtensionMustFailed()
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

    public function testActivateDataMustSuccess()
    {
        $model = File::findOne(1);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataMustFailed()
    {
        $model = File::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}