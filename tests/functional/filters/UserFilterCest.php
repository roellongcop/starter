<?php

class UserFilterCest
{
    public function _before(\FunctionalTester $I)
    {
        
    }

    public function blockedUserCannotOpenDashboard(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\app\models\User::findByUsername('blockeduser'));
        $I->amOnPage(['dashboard/index']);
        $I->see('User is Blocked');
        $I->dontSee('Sign out');
    }

}