<?php

namespace tests\unit\models\form\user;

use app\helpers\App;
use app\models\form\user\ProfileForm;

class ProfileFormTest extends \Codeception\Test\Unit
{
    public function data($replace=[])
    {
        return array_replace([
            'user_id' => 2,
            'first_name' => 'John',
            'last_name' => 'Doe',
        ], $replace);
    }

    public function testFetch()
    {
        $model = new ProfileForm(['user_id' => 1]);
        expect($model->first_name)->equals('admin_firstname');
        expect($model->last_name)->equals('admin_lastname');
    }

    public function testSuccess()
    {
        $model = new ProfileForm($this->data());
        expect_that($model->save());
    }

    public function testRequired()
    {
        $model = new ProfileForm($this->data(['user_id' => NULL]));
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');

        $model = new ProfileForm($this->data(['first_name' => NULL]));
        expect_not($model->save());
        expect($model->errors)->hasKey('first_name');

        $model = new ProfileForm($this->data(['last_name' => NULL]));
        expect_not($model->save());
        expect($model->errors)->hasKey('last_name');
    }

    public function testInvalidUserId()
    {
        $model = new ProfileForm($this->data(['user_id' => 'invalid']));
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testNotExistingUserId()
    {
        $model = new ProfileForm($this->data(['user_id' => 9999]));
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }
}