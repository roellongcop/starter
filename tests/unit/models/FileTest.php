<?php

namespace tests\unit\models;

use app\helpers\App;
use app\models\File;

class FileTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'name' => 'file-name-test',
            'extension' => 'png',
            'size' => 1000,
            'location' => 'default/default-image_200.png',
            'token' => App::randomString(),
            'record_status' => File::RECORD_ACTIVE
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new File($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => File::RECORD_INACTIVE]);

        $model = new File($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new File();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new File($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testCreateInvalidExtension()
    {
        $data = $this->data(['extension' => 'invalid_extension']);

        $model = new File($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('extension');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\File', ['record_status' => File::RECORD_ACTIVE]);
        $model->name = 'update';
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\File', ['record_status' => File::RECORD_ACTIVE]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\File', ['record_status' => File::RECORD_INACTIVE]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\File', ['record_status' => File::RECORD_ACTIVE]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}