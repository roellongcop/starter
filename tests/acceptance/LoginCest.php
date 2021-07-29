<?php

use app\helpers\Url;

class LoginCest
{
    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/login'));
        $I->see('Welcome', 'h3');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'developer@developer.com');
        $I->fillField('input[name="LoginForm[password]"]', 'developer@developer.com');
        $I->click('#kt_login_signin_submit');
        $I->wait(2); // wait for button to be clicked

        $I->expectTo('see user info');
        $I->see('Dashboard', 'h5');

        $I->amOnPage(Url::toRoute('/setting/general'));
        $I->wait(2); // wait for button to be clicked
        $I->see('General Settings', 'h5');
    }
}
