<?php

namespace tests\unit\models\search;

use app\models\search\VisitLogSearch;

class VisitLogSearchTest extends \Codeception\Test\Unit
{
    public function _before()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]));
    }

    public function testSearchWithResult()
    {
        $searchModel = new VisitLogSearch();
        $dataProviders = $searchModel->search(['VisitLogSearch' => ['keywords' => '']]);
        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(4);
    }

    public function testSearchWithNoResult()
    {
        $searchModel = new VisitLogSearch();
        $dataProviders = $searchModel->search([
            'VisitLogSearch' => ['keywords' => 'qwertyuiopasdfghjkl234567890']
        ]);

        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(0);
    }
}