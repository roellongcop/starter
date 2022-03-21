<?php

namespace tests\unit\models\form;

use app\helpers\App;
use app\models\form\ChangePasswordForm;

class ChangePasswordFormTest extends \Codeception\Test\Unit
{
    private function data($replace=[])
    {
        return array_replace([
            'user_id' => 1,
            'password_hint' => 'test',
            'old_password' => 'developer@developer.com',
            'new_password' => 'developer@developer.net',
            'confirm_password' => 'developer@developer.net',
        ], $replace);
    }

    public function testSuccess()
    {
        $model = new ChangePasswordForm($this->data());
        expect_that($model->changePassword());

        expect_that($model->_user->validatePassword($this->data()['new_password']));
    }

    public function testOldPassword()
    {
        $model = new ChangePasswordForm($this->data([
            'old_password' => 'old_password'
        ]));
        expect_not($model->changePassword());
        expect($model->errors)->hasKey('old_password');
    }

    public function testNotExistingUser()
    {
        $model = new ChangePasswordForm($this->data([
            'user_id' => 999999
        ]));
        expect_not($model->changePassword());
        expect($model->errors)->hasKey('user_id');
    }

    public function testSameAsOldPassword()
    {
        $model = new ChangePasswordForm($this->data([
            'new_password' => 'developer@developer.com',
        ]));
        expect_not($model->changePassword());
        expect($model->errors)->hasKey('new_password');
    }

    public function testPasswordConfirm()
    {
        $model = new ChangePasswordForm($this->data([
            'confirm_password' => 'test@test.com',
        ]));
        expect_not($model->changePassword());
        expect($model->errors)->hasKey('confirm_password');
    }

    public function testRequiredFields()
    {
        $model = new ChangePasswordForm($this->data([
            'user_id' => NULL
        ]));
        expect_not($model->changePassword());
        expect($model->errors)->hasKey('user_id');


        $model = new ChangePasswordForm($this->data([
            'old_password' => NULL
        ]));
        expect_not($model->changePassword());
        expect($model->errors)->hasKey('old_password');

        $model = new ChangePasswordForm($this->data([
            'new_password' => NULL
        ]));
        expect_not($model->changePassword());
        expect($model->errors)->hasKey('new_password');

        $model = new ChangePasswordForm($this->data([
            'confirm_password' => NULL
        ]));
        expect_not($model->changePassword());
        expect($model->errors)->hasKey('confirm_password');

        $model = new ChangePasswordForm($this->data([
            'password_hint' => NULL
        ]));
        expect_not($model->changePassword());
        expect($model->errors)->hasKey('password_hint');
    }
}