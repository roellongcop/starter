<?php

namespace tests\unit\models;

use app\models\ModelFile;

class ModelFileTest extends \Codeception\Test\Unit
{
    protected function data()
    {
        return [
            'model_id' => 1,  
            'file_id' => 1,  
            'model_name' => 'User',  
            'extension' => 'png',  
        ];
    }

    public function testCreateSuccess()
    {
        $model = new ModelFile($this->data());
        expect_that($model->save());
    }

    public function testCreateInvalidRecordStatusMustFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new ModelFile($data);
        expect_not($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new ModelFile();
        expect_not($model->save());
    }

    public function testCreateInvalidFileIdMustFailed()
    {
        $data = $this->data();
        $data['file_id'] = 100001;

        $model = new ModelFile($data);

        expect_not($model->save());
        expect($model->errors)->hasKey('file_id');
    }


    public function testCreateInvalidModelIdMustFailed()
    {
        $data = $this->data();
        $data['model_id'] = 100001;
        $model = new ModelFile($data);

        expect_not($model->save());
        expect($model->errors)->hasKey('model_id');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\ModelFile');
        $model->model_id = 2;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\ModelFile');
        expect_that($model->delete());
    }

    public function testActivateDataMustSuccess()
    {
        $model = $this->tester->grabRecord('app\models\ModelFile');
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataMustFailed()
    {
        $model = $this->tester->grabRecord('app\models\ModelFile');
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}