<?php

namespace tests\unit\models\search;

use app\models\search\FileSearch;

class FileSearchTest extends \Codeception\Test\Unit
{
    public function _before()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]));
    }

    public function testSearchWithResult()
    {
        $searchModel = new FileSearch();
        $dataProviders = $searchModel->search(['FileSearch' => ['keywords' => '']]);
        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(3);
    }

    public function testSearchWithNoResult()
    {
        $searchModel = new FileSearch();
        $dataProviders = $searchModel->search([
            'FileSearch' => ['keywords' => 'qwertyuiopasdfghjkl234567890']
        ]);

        expect_that($dataProviders);
        expect(count($dataProviders->models))->equals(0);
    }
}