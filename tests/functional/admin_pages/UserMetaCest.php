<?php
use app\models\User;
use app\models\UserMeta;

class UserMetaCest
{
    public $user;
    public $userMeta;

    public function _before(FunctionalTester $I)
    {
        $this->user = User::findByUsername('developer');
        $this->userMeta = UserMeta::findOne(1);
        $I->amLoggedInAs($this->user);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->userMeta->getIndexUrl(false));
        $I->see('User Metas', 'h5');
    }

    public function createPage(FunctionalTester $I)
    {
        $I->amOnPage($this->userMeta->getCreateUrl(false));
        $I->see('Create User Meta', 'h5');
    }

    public function viewPage(FunctionalTester $I)
    {
        $I->amOnPage($this->userMeta->getViewUrl(false));
        $I->see('User Meta:', 'h5');
    }

    public function updatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->userMeta->getUpdateUrl(false));
        $I->see('Update User Meta:', 'h5');
    }
}
