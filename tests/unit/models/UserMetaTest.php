<?php
namespace tests\unit\models;

use app\models\UserMeta;

class UserMetaTest extends \Codeception\Test\Unit
{
    public function testCreateSuccess()
    {
        $model = new UserMeta([
            'user_id' => 1,  
            'meta_key' => 'address',  
            'meta_value' => 'Philippines',  
            'record_status' => 1,  
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        expect_that($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new UserMeta([
            'record_status' => 1,  
        ]);

        expect_not($model->save());
    }

    public function testCreateInvalidUserIdMustFailed()
    {
        $model = new UserMeta([
            'user_id' => 100001,  
            'meta_key' => 'address',  
            'meta_value' => 'Philippines',  
            'record_status' => 1, 
            'created_by' => 1,
            'updated_by' => 1, 
        ]);

        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testUpdateSuccess()
    {
        $model = UserMeta::findOne(1);
        $model->record_status = 0;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = UserMeta::findOne(1);
        expect_that($model->delete());
    }
}