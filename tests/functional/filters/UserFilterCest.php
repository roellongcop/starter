<?php

use app\models\User;

class UserFilterCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByUsername('blockeduser'));
    }

    public function blockedUserCannotOpenDashboard(\FunctionalTester $I)
    {
        $I->amOnPage(['dashboard/index']);
        $I->see('User is Blocked');
        $I->dontSee('Sign out');
    }
}