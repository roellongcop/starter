<?php

class UserFilterCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabRecord('app\models\User', ['username' => 'blockeduser']));
    }

    public function blockedUserCannotOpenDashboard(\FunctionalTester $I)
    {
        $I->amOnPage(['dashboard/index']);
        $I->see('User is Blocked');
        $I->dontSee('Sign out');
    }
}