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

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data();
        $data['record_status'] = Notification::RECORD_INACTIVE;

        $model = new Notification($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new Notification($data);
        expect_not($model->save());
    }

    public function testCreateInvalidReadStatus()
    {
        $data = $this->data();
        $data['status'] = 3;

        $model = new Notification($data);
        expect_not($model->save());
    }

    public function testCreateNoData()
    {
        $model = new Notification();
        expect_not($model->save());
    }

    public function testCreateInvalidUserId()
    {
        $data = $this->data();
        $data['user_id'] = 10001;
        $model = new Notification($data);

        expect_not($model->save());
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Notification');
        $model->message = 'updated';
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Notification');
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Notification');
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Notification');
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }

    public function testRead()
    {
        $model = $this->tester->grabRecord('app\models\Notification', [
            'status' => Notification::STATUS_UNREAD
        ]);
        expect_that($model);

        $model->setToRead();
        expect_that($model->save());
    }

    public function testUnread()
    {
        $model = $this->tester->grabRecord('app\models\Notification', [
            'status' => Notification::STATUS_READ
        ]);
        expect_that($model);

        $model->setToUnread();
        expect_that($model->save());
    }
}