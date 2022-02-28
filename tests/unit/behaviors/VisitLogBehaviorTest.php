<?php

namespace tests\unit\components;

use app\helpers\App;
use app\models\VisitLog;

class VisitLogBehaviorTest extends \Codeception\Test\Unit
{
    public function testInsertLogAfterLogin()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]));

        $total = VisitLog::find()
            ->login()
            ->count();

        expect($total)->equals(2);
    }

    public function testInsertLogAfterLogout()
    {
        \Yii::$app->user->logout();

        $total = VisitLog::find()
            ->logout()
            ->count();

        expect($total)->equals(1);
    }
}