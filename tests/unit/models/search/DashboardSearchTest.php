<?php

namespace tests\unit\models\search;

use app\models\search\DashboardSearch;

class DashboardSearchTest extends \Codeception\Test\Unit
{
    public function _before()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]));
    }
    
    public function testSearchWithResult()
    {
        $searchModel = new DashboardSearch();
        $dataProviders = $searchModel->search([
            'DashboardSearch' => ['keywords' => 'developer', 'modules' => ['UserSearch']]
        ]);

        expect_that($dataProviders);
    }

    public function testSearchWithNoResult()
    {
        $searchModel = new DashboardSearch();
        $dataProviders = $searchModel->search([
            'DashboardSearch' => ['keywords' => 'noresultsearch', 'modules' => ['UserSearch']]
        ]);

        expect_not($dataProviders);
    }
}