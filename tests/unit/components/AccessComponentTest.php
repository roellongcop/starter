<?php

namespace tests\unit\components;

class AccessComponentTest extends \Codeception\Test\Unit
{
    public $access;
    public $user;

    public function _before()
    {
        $this->access = \Yii::$app->access;
        $this->user = $this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]);
    }

    public function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testGetControllerActions()
    {
        expect_that(is_array($this->access->controllerActions));
        expect_that($this->access->controllerActions);
    }

    public function testGetDefaultNavigations()
    {
        expect_that(is_array($this->access->defaultNavigation));
        expect_that($this->access->defaultNavigation);
    }

    public function testActions()
    {
        expect_that(is_array($this->access->actions('user')));
        expect_that($this->access->actions('user'));
    }

    public function testMyActionsGuest()
    {
        expect($this->access->my_actions())->equals(['']);
    }

    public function testMyActionsDeveloper()
    {
        \Yii::$app->user->login($this->user);
        expect_that(is_array($this->access->my_actions('user')));
        expect_that($this->access->my_actions('user'));
        expect($this->access->my_actions('user'))->hasKey(1);
        expect(sizeof($this->access->my_actions('user')))->equals(18);
    }

    public function testUserCanRoute()
    {
        \Yii::$app->user->login($this->user);
        expect_that($this->access->userCanRoute(['dashboard/index']));
    }

    public function testGuestUserCannotRoute()
    {
        expect_not($this->access->userCanRoute(['dashboard/index']));
    }

    public function testUserCan()
    {
        \Yii::$app->user->login($this->user);
        expect_that($this->access->userCan('index', 'dashboard'));
    }

    public function testGuestUserCan()
    {
        expect_not($this->access->userCan('index', 'dashboard'));
    }

    public function testGetModuleFilter()
    {
        \Yii::$app->user->login($this->user);
        expect_that($this->access->getModuleFilter());
        expect_that(is_array($this->access->getModuleFilter()));
        expect($this->access->getModuleFilter())->hasKey('BackupSearch');
    }

    public function testGuestGetModuleFilter()
    {
        expect_not($this->access->getModuleFilter());
    }

    public function testGetSearchModels()
    {
        expect_that(is_array($this->access->searchModels));
        expect_that($this->access->searchModels);
    }
}