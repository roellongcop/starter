<?php

class LoginFormCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Welcome', 'h3');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage(['dashboard/index']);
        $I->see('Sign Out');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\app\models\User::findByUsername('admin'));
        $I->amOnPage(['dashboard/index']);
        $I->see('Sign Out');
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_signin_form', []);
        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_signin_form', [
            'LoginForm[username]' => 'admin',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.');
    }


    public function loginInactiveUser(\FunctionalTester $I)
    {
         $I->submitForm('#kt_login_signin_form', [
            'LoginForm[username]' => 'inactive_user@inactive_user.com',
            'LoginForm[password]' => 'inactive_user@inactive_user.com',
        ]);
        $I->expectTo('see validations errors');
        $I->see('User is inactive');
    }

    public function loginNotVerifiedUser(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_signin_form', [
            'LoginForm[username]' => 'not_verified_user@not_verified_user.com',
            'LoginForm[password]' => 'not_verified_user@not_verified_user.com',
        ]);
        $I->expectTo('see validations errors');
        $I->see('User is not verified');
    }

    public function loginBlockedUser(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_signin_form', [
            'LoginForm[username]' => 'blocked_user@blocked_user.com',
            'LoginForm[password]' => 'blocked_user@blocked_user.com',
        ]);
        $I->expectTo('see validations errors');
        $I->see('User is blocked');
    }

    public function loginInactiveRoleUser(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_signin_form', [
            'LoginForm[username]' => 'inactive_role_user@inactive_role_user.com',
            'LoginForm[password]' => 'inactive_role_user@inactive_role_user.com',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Role is inactive');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_signin_form', [
            'LoginForm[username]' => 'admin@admin.com',
            'LoginForm[password]' => 'admin@admin.com',
        ]);
        $I->see('Sign Out');
        $I->dontSeeElement('form#kt_login_signin_form');              
    }
}