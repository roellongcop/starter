<?php

namespace tests\unit\models;

use app\models\ModelFile;

class ModelFileTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'model_id' => 1,  
            'file_id' => 1,  
            'model_name' => 'User',  
            'extension' => 'png',
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new ModelFile($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => ModelFile::RECORD_INACTIVE]);

        $model = new ModelFile($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new ModelFile($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testCreateNoData()
    {
        $model = new ModelFile();
        expect_not($model->save());
    }

    public function testCreateInvalidFileId()
    {
        $data = $this->data(['file_id' => 999999]);

        $model = new ModelFile($data);

        expect_not($model->save());
        expect($model->errors)->hasKey('file_id');
    }


    public function testCreateInvalidModelId()
    {
        $data = $this->data(['model_id' => 999999]);
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

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\ModelFile');
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\ModelFile');
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}