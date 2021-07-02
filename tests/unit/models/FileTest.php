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

    public function testCreateNoData()
    {
        $model = new File();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new File($data);
        expect_not($model->save());
    }

    public function testCreateInvalidExtension()
    {
        $data = $this->data();
        $data['extension'] = 'invalid_extension';

        $model = new File($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('extension');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\File');
        $model->name = 'update';
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\File');
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\File');
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\File');
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}