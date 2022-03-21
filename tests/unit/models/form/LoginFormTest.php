<?php

namespace tests\unit\models\form;

use app\models\form\LoginForm;

class LoginFormTest extends \Codeception\Test\Unit
{
    private $model;

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testLoginNotExistingUser()
    {
        $this->model = new LoginForm([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testLoginWithWrongPassword()
    {
        $this->model = new LoginForm([
            'username' => 'demo',
            'password' => 'wrong_password',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasKey('password');
    }


    public function testLoginBlockedUser()
    {
        $this->model = new LoginForm([
            'username' => 'blockeduser',
            'password' => 'blockeduser@blockeduser.com',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testLoginNotVerifiedUser()
    {
        $this->model = new LoginForm([
            'username' => 'notverifieduser',
            'password' => 'notverifieduser@notverifieduser.com',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testLoginInactiveUser()
    {
        $this->model = new LoginForm([
            'username' => 'inactiveuser',
            'password' => 'inactiveuser@inactiveuser.com',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testLoginInactiveRoleUser()
    {
        $this->model = new LoginForm([
            'username' => 'inactiveroleuser',
            'password' => 'inactiveroleuser@inactiveroleuser.com',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testLoginCorrectCredential()
    {
        $this->model = new LoginForm([
            'username' => 'developer@developer.com',
            'password' => 'developer@developer.com',
        ]);

        expect_that($this->model->login());
        expect_not(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasntKey('password');
    }
}