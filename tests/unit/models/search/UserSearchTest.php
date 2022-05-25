<?php

namespace tests\unit\models\search;

use app\models\search\UserSearch;

class UserSearchTest extends \Codeception\Test\Unit
{
    public function _before()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]));
    }

    public function testSearchWithResult()
    {
        $searchModel = new UserSearch();
        $dataProviders = $searchModel->search(['UserSearch' => ['keywords' => '']]);
        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(6);
    }

    public function testSearchWithNoResult()
    {
        $searchModel = new UserSearch();
        $dataProviders = $searchModel->search([
            'UserSearch' => ['keywords' => 'qwertyuiopasdfghjkl234567890']
        ]);

        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(0);
    }
}