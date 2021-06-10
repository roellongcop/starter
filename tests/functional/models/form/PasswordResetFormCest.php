<?php

class PasswordResetFormCest 
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnPage(['site/login']);
    }

    public function openPasswordPage(\FunctionalTester $I)
    {
        $I->see('Forgotten Password', 'h3');        
    }

    public function submitEmptyForm(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_forgot_form', []);
        $I->expectTo('see validations errors');
        $I->see('Forgotten Password', 'h3');
        $I->see('Email cannot be blank');
    }

    public function submitFormWithIncorrectEmail(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_forgot_form', [
            'PasswordResetForm[email]' => 'tester.email',
        ]);
        $I->expectTo('see that email address is wrong');
        $I->see('Email is not a valid email address.');
    }

    public function submitFormSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_forgot_form', [
            'PasswordResetForm[email]' => 'developer@developer.com',
        ]);
        $I->seeEmailIsSent();
        $I->see('Email sent.');        
    }

    public function submitFormWithHintSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#kt_login_forgot_form', [
            'PasswordResetForm[email]' => 'developer@developer.com',
            'PasswordResetForm[hint]' => 1
        ]);
        $I->see("Your password hint is: 'Same as Email'.");        
    }
}
