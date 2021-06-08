<?php
use app\models\User;
use app\models\Log;

// Admin page functional test cest file. Move this file to @app\tests\functional\admin_pages

class LogCest
{
    public $user;
    public $model;

    public function _before(FunctionalTester $I)
    {
        $this->user = User::findByUsername('developer');
        $this->model = Log::findOne(1);
        $I->amLoggedInAs($this->user);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->see('Logs', 'h5');
    }

  
    public function viewPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));
        $I->see('Log:', 'h5');
    }


    public function bulkActionPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->submitForm('form[action="/log/process-checkbox"]', [
            'process-selected' => 'active', 
            'selection' => [1]
        ]);
        $I->see('Confirm Action', 'h5');
    }
}
