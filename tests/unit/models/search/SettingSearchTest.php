<?php

namespace tests\unit\models\search;

use app\models\search\SettingSearch;

class SettingSearchTest extends \Codeception\Test\Unit
{
    public function _before()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]));
    }

    public function testSearchWithResult()
    {
        $searchModel = new SettingSearch();
        $dataProviders = $searchModel->search(['SettingSearch' => ['keywords' => '']]);
        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(2);
    }

    public function testSearchWithNoResult()
    {
        $searchModel = new SettingSearch();
        $dataProviders = $searchModel->search([
            'SettingSearch' => ['keywords' => 'qwertyuiopasdfghjkl234567890']
        ]);

        expect_that($dataProviders);
        expect(count($dataProviders->models))->equals(0);
    }
}