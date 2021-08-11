<?php

namespace tests\unit\models;

use app\filters\UserFilter;
use app\helpers\App;

class UserFilterTest extends \Codeception\Test\Unit
{
    public function testValid()
    {
        $model = new UserFilter();

        expect_that($model->beforeAction(true));
    }

    public function testBlocked()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', ['username' => 'blockeduser']));

        $this->tester->expectThrowable(
            new \yii\web\ForbiddenHttpException('User is Blocked !'), 
            function() {
                $model = new UserFilter();
                expect_that($model->beforeAction(true));
            }
        );
    }
}