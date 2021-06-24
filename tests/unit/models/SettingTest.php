<?php

namespace tests\unit\models;

use app\models\Setting;
use yii\helpers\Inflector;

class SettingTest extends \Codeception\Test\Unit
{
    protected function data()
    {
        return [
            'name' => 'timezone',
            'value' => 'Asia/Manila',
            'slug' => Inflector::slug('timezone'),
            'type' => 'general',
            'sort_order' => 0,
            'record_status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }

    public function testCreateSuccess()
    {
        $model = new Setting($this->data());
        expect_that($model->save());
    }

    public function testCreateNoDataFailed()
    {
        $model = new Setting();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatusFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new Setting($data);
        expect_not($model->save());
    }

    public function testUpdateSuccess()
    {
        $model = Setting::findOne(1);
        $model->name = 'updated';
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = Setting::findOne(1);
        expect_that($model->delete());
    }

    public function testActivateDataSuccess()
    {
        $model = Setting::findOne(1);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataFailed()
    {
        $model = Setting::findOne(1);
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}