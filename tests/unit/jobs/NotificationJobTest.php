<?php

namespace tests\unit\jobs;

use app\jobs\NotificationJob;

class NotificationJobTest extends \Codeception\Test\Unit
{
    public function testExecute()
    {
        $model = new NotificationJob([
            'user_id' => 1,
            'type' => 'notification_change_password',
            'message' => 'testing content',
            'link' => 'http://starter.test/my-password',
        ]);

        expect_that($model->execute(1));

        $this->tester->seeRecord('app\models\Notification', [
            'user_id' => 1,
            'type' => 'notification_change_password',
            'message' => 'testing content',
            'link' => 'http://starter.test/my-password',
        ]);
    }
}