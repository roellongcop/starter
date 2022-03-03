<?php

namespace tests\unit\models\search;

use app\models\search\UserMetaSearch;

class UserMetaSearchTest extends \Codeception\Test\Unit
{
    public function _before()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]));
    }

    public function testSearchWithResult()
    {
        $searchModel = new UserMetaSearch();
        $dataProviders = $searchModel->search(['UserMetaSearch' => ['keywords' => '']]);
        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(3);
    }

    public function testSearchWithNoResult()
    {
        $searchModel = new UserMetaSearch();
        $dataProviders = $searchModel->search([
            'UserMetaSearch' => ['keywords' => 'qwertyuiopasdfghjkl234567890']
        ]);

        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(0);
    }
}