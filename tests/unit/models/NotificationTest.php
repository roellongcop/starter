<?php

namespace tests\unit\models;

use app\helpers\Url;
use app\models\Notification;

class NotificationTest extends \Codeception\Test\Unit
{
    protected function data()
    {
        return [
            'user_id' => 1,
            'message' => 'You\'ve Change your password',
            'link' => Url::to(['/user/my-password']),
            'type' => 'notification_change_password',
            'token' => 'TftF853osh1623298888',
            'status' => Notification::STATUS_UNREAD,
            'created_by' => 1,
            'updated_by' => 1, 
        ];
    }

    public function testCreateSuccess()
    {
        $model = new Notification($this->data());
        expect_that($model->save());
    }

    public function testCreateInvalidRecordStatusMustFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new Notification($data);
        expect_not($model->save());
    }

    public function testCreateInvalidReadStatusMustFailed()
    {
        $data = $this->data();
        $data['status'] = 3;

        $model = new Notification($data);
        expect_not($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new Notification();
        expect_not($model->save());
    }

    public function testCreateInvalidUserIdMustFailed()
    {
        $data = $this->data();
        $data['user_id'] = 10001;
        $model = new Notification($data);

        expect_not($model->save());
    }

    public function testUpdateSuccess()
    {
        $model = Notification::findOne(1);
        $model->message = 'updated';
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = Notification::findOne(1);
        expect_that($model->delete());
    }

    public function testActivateDataMustSuccess()
    {
        $model = Notification::findOne(1);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataMustFailed()
    {
        $model = Notification::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }

    public function testReadMustSuccess()
    {
        $model = Notification::find()
            ->unread()
            ->one();
        expect_that($model);

        $model->setToRead();
        expect_that($model->save());
    }

    public function testUnreadMustSuccess()
    {
        $model = Notification::find()
            ->read()
            ->one();
        expect_that($model);

        $model->setToUnread();
        expect_that($model->save());
    }
}