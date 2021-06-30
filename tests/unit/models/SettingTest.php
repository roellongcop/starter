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
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }

    public function testCreateSuccess()
    {
        $model = new Setting($this->data());
        expect_that($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new Setting();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatusMustFailed()
    {
        $data = $this->data();
        $data['record_status'] = 3;

        $model = new Setting($data);
        expect_not($model->save());
    }

    public function testCreateInvalidTypeMustFailed()
    {
        $data = $this->data();
        $data['type'] = 'invalid-type';

        $model = new Setting($data);
        expect_not($model->save());
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

    public function testActivateDataMustSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Setting');
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateDataMustFailed()
    {
        $model = $this->tester->grabRecord('app\models\Setting');
        expect_that($model);

        $model->deactivate();
        expect_not($model->save());
    }
}