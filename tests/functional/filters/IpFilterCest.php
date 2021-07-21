<?php

use app\helpers\App;
use app\models\Ip;

class IpFilterCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabRecord('app\models\User', ['username' => 'developer']));
    }

    // public function blockedIp(\FunctionalTester $I)
    // {
    //     $ip = new Ip([
    //         'name' => 'Not Detected', 
    //         'description' => 'testing IP',
    //         'type' => Ip::TYPE_BLACKLIST,
    //     ]);
    //     $ip->logAfterSave = false;
    //     $ip->save(false);

    //    var_dump($ip->errors); die;

    //     $I->amOnPage(['dashboard/index']);

    //     $I->see('IP is Blocked !');
    //     $I->dontSee('Sign out');
    // }
}