<?php

namespace tests\unit\models;

use app\models\form\LoginForm;

class LoginFormTest extends \Codeception\Test\Unit
{
    private $model;

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testLoginNoUser()
    {
        $this->model = new LoginForm([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testLoginWrongPassword()
    {
        $this->model = new LoginForm([
            'username' => 'demo',
            'password' => 'wrong_password',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasKey('password');
    }


    public function testBlockedUserLogin()
    {
        $this->model = new LoginForm([
            'username' => 'blocked_user',
            'password' => 'blocked_user@blocked_user.com',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testNotValidateUserLogin()
    {
        $this->model = new LoginForm([
            'username' => 'novalidate_user',
            'password' => 'novalidate_user@novalidate_user.com',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testInactiveUserLogin()
    {
        $this->model = new LoginForm([
            'username' => 'inactive_user',
            'password' => 'inactive_user@inactive_user.com',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testLoginCorrect()
    {
        $this->model = new LoginForm([
            'username' => 'admin@admin.com',
            'password' => 'admin@admin.com',
        ]);

        expect_that($this->model->login());
        expect_not(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasntKey('password');
    }

}
