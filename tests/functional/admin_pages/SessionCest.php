<?php

use app\models\User;
use app\models\Session;

class SessionCest
{
    public $user;
    public $model;

    public function _before(FunctionalTester $I)
    {
        $this->user = User::findByUsername('developer');
        $this->model = Session::findOne('in2jfqrqoj5d6luo7qleggimid');
        $I->amLoggedInAs($this->user);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->see('Sessions', 'h5');
    }

    public function viewPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));
        $I->see('Session:', 'h5');
    }

    public function bulkActionPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->submitForm('form[action="/session/confirm-action"]', [
            'process-selected' => 'active', 
            'selection' => ['in2jfqrqoj5d6luo7qleggimid']
        ]);
        $I->see('Confirm Action', 'h5');
    }

    public function printPage(FunctionalTester $I)
    {
        $I->amOnPage(['session/print']);
        $I->see('Session Report');
    }
}