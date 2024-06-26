<?php

namespace tests\unit\models\search;

use app\models\search\SessionSearch;

class SessionSearchTest extends \Codeception\Test\Unit
{
    public function _before()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]));
    }

    public function testSearchWithResult()
    {
        $searchModel = new SessionSearch();
        $dataProviders = $searchModel->search(['SessionSearch' => ['keywords' => '']]);
        expect_that($dataProviders);
        expect(count($dataProviders->models))->equals(3);
    }

    public function testSearchWithNoResult()
    {
        $searchModel = new SessionSearch();
        $dataProviders = $searchModel->search([
            'SessionSearch' => ['keywords' => 'qwertyuiopasdfghjkl234567890']
        ]);

        expect_that($dataProviders);
        expect(count($dataProviders->models))->equals(0);
    }
}