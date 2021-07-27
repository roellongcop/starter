<?php

namespace tests\unit\models;

use app\models\UserMeta;

class UserMetaTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'user_id' => 1,  
            'name' => 'address',  
            'value' => 'Philippines',  
            'created_by' => 1,
            'updated_by' => 1,
            'record_status' => UserMeta::RECORD_ACTIVE
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new UserMeta($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => UserMeta::RECORD_INACTIVE]);

        $model = new UserMeta($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new UserMeta();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new UserMeta($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testCreateInvalidUserId()
    {
        $data = $this->data(['user_id' => 999999]);
        $model = new UserMeta($data);

        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\UserMeta', [
            'record_status' => UserMeta::RECORD_ACTIVE
        ]);
        $model->user_id = 2;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\UserMeta', [
            'record_status' => UserMeta::RECORD_ACTIVE
        ]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\UserMeta', [
            'record_status' => UserMeta::RECORD_INACTIVE
        ]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\UserMeta', [
            'record_status' => UserMeta::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}