<?php

namespace tests\unit\models;

use app\models\UserMeta;

class UserMetaTest extends \Codeception\Test\Unit
{
    protected function data()
    {
        return [
            'user_id' => 1,  
            'meta_key' => 'address',  
            'meta_value' => 'Philippines',  
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }

    public function testCreateSuccess()
    {
        $model = new UserMeta($this->data());
        expect_that($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new UserMeta();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatusMustFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new UserMeta($data);
        expect_not($model->save());
    }

    public function testCreateInvalidUserIdMustFailed()
    {
        $data = $this->data();
        $data['user_id'] = 100001;
        $model = new UserMeta($data);

        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testUpdateSuccess()
    {
        $model = UserMeta::findOne(1);
        $model->user_id = 2;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = UserMeta::findOne(1);
        expect_that($model->delete());
    }

    public function testActivateDataMustSuccess()
    {
        $model = UserMeta::findOne(1);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataMustFailed()
    {
        $model = UserMeta::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}