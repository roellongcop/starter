<?php

use app\models\User;

class DashboardCest
{
    public function _before(FunctionalTester $I)
    {
        $user = User::findByUsername('developer');
        $I->amLoggedInAs($user);
        $I->amOnPage(['dashboard/index']);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }


    public function openPage(FunctionalTester $I)
    {
        $I->see('Dashboard', 'h5');
    }

    public function searchWithResults(FunctionalTester $I)
    {
        $I->submitForm('#main-search-form', [
            'keywords' => '1'
        ]);
        $I->see('Search result for');
    }

    public function searchWithNoResult(FunctionalTester $I)
    {
        $I->submitForm('#main-search-form', [
            'keywords' => 'noresults'
        ]);
        $I->see('No data found');
    }
}
