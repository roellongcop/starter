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
    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_signin_form', []);
        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }
}