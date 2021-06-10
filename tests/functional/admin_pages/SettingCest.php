<?php
use app\models\User;
use app\models\Setting;

class SettingCest
{
    public $user;
    public $model;

    public function _before(FunctionalTester $I)
    {
        $this->user = User::findByUsername('developer');
        $this->model = Setting::findOne(1);
        $I->amLoggedInAs($this->user);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->see('Settings', 'h5');
    }

    public function mySettingPage(FunctionalTester $I)
    {
        $I->amOnPage(['setting/my-setting']);
        $I->see('My Settings', 'h5');
    }

    public function generalSettingPage(FunctionalTester $I)
    {
        $I->amOnPage(['setting/general']);
        $I->see('General Settings', 'h5');
    }

    public function viewPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));
        $I->see('Setting:', 'h5');
    }

    public function updatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getUpdateUrl(false));
        $I->see('Update Setting:', 'h5');
    }

    public function bulkActionPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->submitForm('form[action="/setting/confirm-action"]', [
            'process-selected' => 'active', 
            'selection' => [1]
        ]);
        $I->see('Confirm Action', 'h5');
    }
}