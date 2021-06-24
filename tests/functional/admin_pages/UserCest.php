<?php

use app\helpers\App;
use app\models\Role;
use app\models\User;

class UserCest
{
    public $model;

    public function _before(FunctionalTester $I)
    {
        $this->model = User::findByUsername('developer');
        $I->amLoggedInAs($this->model);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->see('Users', 'h5');
    }

    public function myAccountPage(FunctionalTester $I)
    {
        $I->amOnPage(['user/my-account']);
        $I->see('Update Account', 'h5');
    }

    public function myPasswordPage(FunctionalTester $I)
    {
        $I->amOnPage(['user/my-password']);
        $I->see('My Password', 'h5');
    }

    public function createPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->see('Create User', 'h5');
    }

    public function createUserInactiveRoleNoAccessFailed(FunctionalTester $I)
    {
        Yii::$app->user->logout();
        $this->model = User::findByUsername('noinactiveroleuser');
        $I->amLoggedInAs($this->model);
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->see('Create User', 'h5');

        $role = Role::findOne(['name' => 'developernoiactiverole']);

        $I->submitForm('#user-form', [
            'User[role_id]' => $role->id,
            'User[username]' => 'testusername',
            'User[email]' => 'testusername@testusername.com',
            'User[password]' => 'testusername@testusername.com',
            'User[password_repeat]' => 'testusername@testusername.com',
            'User[status]' => 10,
            'User[record_status]' => 1,
            'User[is_blocked]' => 0,
        ]);

        $I->expectTo('See validation on user cannot select inactive role when he/she have no access');
        $I->see('User don\'t have access to role');
    }

    public function viewPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));
        $I->see('User:', 'h5');
    }

    public function updatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getUpdateUrl(false));
        $I->see('Update User:', 'h5');
    }
 
    public function duplicatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getDuplicateUrl(false));
        $I->see('Duplicate User:', 'h5');
    }

    public function bulkActionPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->submitForm('form[action="/user/confirm-action"]', [
            'process-selected' => 'active', 
            'selection' => [1]
        ]);
        $I->see('Confirm Action', 'h5');
    }

    public function profilePage(FunctionalTester $I)
    {
        $I->amOnPage(['user/profile', 'slug' => $this->model->slug]);
        $I->see('Profile:', 'h5');
    }

    public function printPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getPrintUrl(false));
        $I->see('User Report');
    }

    public function exportPdfPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getExportPdfUrl(false)); 
        $I->expectTo('See no errors');
    }

    public function exportCsvPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getExportCsvUrl(false));
        $I->expectTo('See no errors');
    }

    public function exportXlsPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getExportXlsUrl(false));
        $I->expectTo('See no errors');
    }

    public function exportXlsxPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getExportXlsxUrl(false));
        $I->expectTo('See no errors');
    }
}