<?php

namespace tests\unit\models\form\user;

use app\helpers\App;
use app\models\form\user\MySettingForm;

class MySettingFormTest extends \Codeception\Test\Unit
{
    public function data($replace=[])
    {
        return array_replace([
            'user_id' => 2,
            'theme_id' => 1,
        ], $replace);
    }

    public function testFetch()
    {
        $model = new MySettingForm(['user_id' => 1]);
        expect($model->theme_id)->equals(1);
    }

    public function testSuccess()
    {
        $model = new MySettingForm($this->data());
        expect_that($model->save());
    }

    public function testRequired()
    {
        $model = new MySettingForm($this->data(['user_id' => NULL]));
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');

        $model = new MySettingForm($this->data(['theme_id' => NULL]));
        expect_not($model->save());
        expect($model->errors)->hasKey('theme_id');
    }

    public function testInvalidUserId()
    {
        $model = new MySettingForm($this->data(['user_id' => 'invalid']));
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testNotExistingUserId()
    {
        $model = new MySettingForm($this->data(['user_id' => 9999]));
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testInvalidThemeId()
    {
        $model = new MySettingForm($this->data(['theme_id' => 'invalid']));
        expect_not($model->save());
        expect($model->errors)->hasKey('theme_id');
    }

    public function testNotExistingThemeId()
    {
        $model = new MySettingForm($this->data(['theme_id' => 9999]));
        expect_not($model->save());
        expect($model->errors)->hasKey('theme_id');
    }
}