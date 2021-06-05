<?php
use app\models\User;
use app\models\Ip;

// Admin page functional test cest file. Move this file to @app\tests\functional\admin_pages

class IpCest
{
    public $user;
    public $model;

    public function _before(FunctionalTester $I)
    {
        $this->user = User::findByUsername('developer');
        $this->model = Ip::findOne(1);
        $I->amLoggedInAs($this->user);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->see('Ips', 'h5');
    }

    public function createPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->see('Create Ip', 'h5');
    }

    public function viewPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));
        $I->see('Ip:', 'h5');
    }

    public function updatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getUpdateUrl(false));
        $I->see('Update Ip:', 'h5');
    }


    public function bulkActionPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->submitForm('form[action="/ip/process-checkbox"]', [
            'process-selected' => 'active', 
            'selection' => [1]
        ]);
        $I->see('Confirm Action', 'h5');
    }
}
