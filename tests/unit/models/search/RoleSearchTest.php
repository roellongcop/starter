<?php

namespace tests\unit\models\search;

use app\models\search\RoleSearch;

class RoleSearchTest extends \Codeception\Test\Unit
{
    public function _before()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]));
    }

    public function testSearchWithResult()
    {
        $searchModel = new RoleSearch();
        $dataProviders = $searchModel->search(['RoleSearch' => ['keywords' => '']]);
        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(3);
    }

    public function testSearchWithNoResult()
    {
        $searchModel = new RoleSearch();
        $dataProviders = $searchModel->search([
            'RoleSearch' => ['keywords' => 'qwertyuiopasdfghjkl234567890']
        ]);

        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(0);
    }
}