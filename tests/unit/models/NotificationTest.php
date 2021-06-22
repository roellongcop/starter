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
            'status' => 1,
            'record_status' => 1,
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
        $model->record_status = 0;
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

    public function testDeactivateDataMustSuccess()
    {
        $model = Notification::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_that($model->save());
    }
}