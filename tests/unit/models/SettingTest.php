<?php

namespace tests\unit\models;

use app\models\Setting;
use yii\helpers\Inflector;

class SettingTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'name' => 'timezone',
            'value' => 'Asia/Manila',
            'slug' => Inflector::slug('timezone'),
            'type' => 'general',
            'sort_order' => 0,
            'created_by' => 1,
            'updated_by' => 1,
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new Setting($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => Setting::RECORD_INACTIVE]);

        $model = new Setting($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new Setting();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new Setting($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testCreateInvalidType()
    {
        $data = $this->data(['type' => 'invalid-type']);

        $model = new Setting($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('type');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Setting');
        $model->name = 'updated';
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Setting');
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Setting');
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Setting');
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}