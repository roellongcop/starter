<?php

use app\helpers\App;
use app\models\Ip;
use app\models\form\SettingForm;

class IpFilterCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabRecord('app\models\User', ['username' => 'developer']));
    }

    public function accessSuccess(\FunctionalTester $I)
    {
        $I->amOnPage(['dashboard/index']);
        $I->see('Dashboard', 'h5');
    }

    public function blacklist(\FunctionalTester $I)
    {
        $I->amOnPage(['dashboard/index']);

        $model = $I->grabRecord('app\models\Ip', ['name' => '000.000.0.0']);
        $model->type = Ip::TYPE_BLACKLIST;
        $model->save();

        $I->amOnPage(['dashboard/index']);
        $I->see('IP is Blocked !');
        $I->dontSee('Sign out');
    }

    public function whitelist(\FunctionalTester $I)
    {
        $I->amOnPage(['dashboard/index']);
        
        $I->haveRecord('app\models\Setting', ['name' => 'whitelist_ip_only', 'value' => 1]);

        $I->amOnPage(['dashboard/index']);

        $I->see('IP not WhiteListed.');
        $I->dontSee('Sign out');
    }
}