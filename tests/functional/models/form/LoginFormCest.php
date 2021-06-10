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
        $I->amLoggedInAs(\app\models\User::findByUsername('developer'));
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
            'LoginForm[username]' => 'developer',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.');
    }


    public function loginInactiveUser(\FunctionalTester $I)
    {
         $I->submitForm('#kt_login_signin_form', [
            'LoginForm[username]' => 'inactiveuser@inactiveuser.com',
            'LoginForm[password]' => 'inactiveuser@inactiveuser.com',
        ]);
        $I->expectTo('see validations errors');
        $I->see('User is inactive');
    }

    public function loginNotVerifiedUser(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_signin_form', [
            'LoginForm[username]' => 'notverifieduser@notverifieduser.com',
            'LoginForm[password]' => 'notverifieduser@notverifieduser.com',
        ]);
        $I->expectTo('see validations errors');
        $I->see('User is not verified');
    }

    public function loginBlockedUser(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_signin_form', [
            'LoginForm[username]' => 'blockeduser@blockeduser.com',
            'LoginForm[password]' => 'blockeduser@blockeduser.com',
        ]);
        $I->expectTo('see validations errors');
        $I->see('User is blocked');
    }

    public function loginInactiveRoleUser(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_signin_form', [
            'LoginForm[username]' => 'inactiveroleuser@inactiveroleuser.com',
            'LoginForm[password]' => 'inactiveroleuser@inactiveroleuser.com',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Role is inactive');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_signin_form', [
            'LoginForm[username]' => 'developer@developer.com',
            'LoginForm[password]' => 'developer@developer.com',
        ]);
        $I->see('Sign Out');
        $I->dontSeeElement('form#kt_login_signin_form');              
    }
}