<?php

namespace tests\unit\components;

use app\helpers\App;
use app\helpers\Url;
use app\models\Notification;

class TokenBehaviorTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'user_id' => 1,
            'message' => 'You\'ve Change your password',
            'link' => Url::to(['user/my-password']),
            'type' => 'notification_change_password',
            'status' => Notification::STATUS_UNREAD,
            'record_status' => Notification::RECORD_ACTIVE
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new Notification($this->data());
        expect_that($model->save());
        expect_that($model->token);
    }
}