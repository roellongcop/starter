<?php
use app\helpers\App;
use app\models\Role;
use app\models\User;

class UserCest
{
    public $user;

    public function _before(FunctionalTester $I)
    {
        $this->user = User::findByUsername('developer');
        $I->amLoggedInAs($this->user);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->user->getIndexUrl(false));
        $I->see('Users', 'h5');
    }

    public function createPage(FunctionalTester $I)
    {
        $I->amOnPage($this->user->getCreateUrl(false));
        $I->see('Create User', 'h5');
    }

    public function createUserInactiveRoleNoAccessMustFailed(FunctionalTester $I)
    {
        Yii::$app->user->logout();
        $this->user = User::findByUsername('noinactiveroleuser');
        $I->amLoggedInAs($this->user);
        $I->amOnPage($this->user->getCreateUrl(false));
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
        $I->amOnPage($this->user->getViewUrl(false));
        $I->see('User:', 'h5');
    }

    public function updatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->user->getUpdateUrl(false));
        $I->see('Update User:', 'h5');
    }
 

    public function duplicatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->user->getDuplicateUrl(false));
        $I->see('Duplicate User:', 'h5');
    }

    public function bulkActionPage(FunctionalTester $I)
    {
        $I->amOnPage($this->user->getIndexUrl(false));
        $I->submitForm('form[action="/user/confirm-action"]', [
            'process-selected' => 'active', 
            'selection' => [1]
        ]);
        $I->see('Confirm Action', 'h5');
    }


    public function profilePage(FunctionalTester $I)
    {
        $I->amOnPage(['user/profile', 'slug' => $this->user->slug]);
        $I->see('Profile:', 'h5');
    }
}