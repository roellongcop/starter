<?php
namespace tests\unit\models;

use app\helpers\Url;
use app\models\Notification;

class NotificationTest extends \Codeception\Test\Unit
{
    public function testCreate()
    {
        $model = new Notification([
            'user_id' => 1,
            'message' => 'You\'ve Change your password',
            'link' => Url::to(['/user/my-password']),
            'type' => 'notification_change_password',
            'token' => 'TftF853osh1623298888',
            'status' => 1,
            'record_status' => 1,
            'created_by' => 1,
            'updated_by' => 1, 
        ]);

        expect_that($model->save());
    }

    public function testCreateNoData()
    {
        $model = new Notification([
            'record_status' => 1
        ]);
        expect_not($model->save());
    }

    public function testCreateInvalidUserId()
    {
        $model = new Notification([
            'user_id' => 10001,
            'message' => 'You\'ve Change your password',
            'link' => Url::to(['/user/my-password']),
            'type' => 'notification_change_password',
            'token' => 'TftF853osh1623298888',
            'status' => 1,
            'record_status' => 1,
            'created_by' => 1,
            'updated_by' => 1, 
        ]);

        expect_not($model->save());
    }

    public function testUpdate()
    {
        $model = Notification::findOne(1);
        $model->record_status = 0;
        expect_that($model->save());
    }

    public function testDelete()
    {
        $model = Notification::findOne(1);
        expect_that($model->delete());
    }
}