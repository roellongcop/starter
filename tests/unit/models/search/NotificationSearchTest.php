<?php

namespace tests\unit\models\search;

use app\models\search\NotificationSearch;

class NotificationSearchTest extends \Codeception\Test\Unit
{
    public function _before()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]));
    }

    public function testSearchWithResult()
    {
        $searchModel = new NotificationSearch();
        $dataProviders = $searchModel->search(['NotificationSearch' => ['keywords' => '']]);
        expect_that($dataProviders);
        expect(count($dataProviders->models))->equals(3);
    }

    public function testSearchWithNoResult()
    {
        $searchModel = new NotificationSearch();
        $dataProviders = $searchModel->search([
            'NotificationSearch' => ['keywords' => 'qwertyuiopasdfghjkl234567890']
        ]);

        expect_that($dataProviders);
        expect(count($dataProviders->models))->equals(0);
    }
}