<?php

namespace tests\unit\models\search;

use app\models\search\ThemeSearch;

class ThemeSearchTest extends \Codeception\Test\Unit
{
    public function _before()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]));
    }

    public function testSearchWithResult()
    {
        $searchModel = new ThemeSearch();
        $dataProviders = $searchModel->search(['ThemeSearch' => ['keywords' => '']]);
        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(14);
    }

    public function testSearchWithNoResult()
    {
        $searchModel = new ThemeSearch();
        $dataProviders = $searchModel->search([
            'ThemeSearch' => ['keywords' => 'qwertyuiopasdfghjkl234567890']
        ]);

        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(0);
    }
}