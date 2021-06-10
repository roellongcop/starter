<?php
namespace tests\unit\models;

use app\models\Setting;
use yii\helpers\Inflector;

class SettingTest extends \Codeception\Test\Unit
{
    public function testCreateSuccess()
    {
        $model = new Setting([
            'name' => 'timezone',
            'value' => 'Asia/Manila',
            'slug' => Inflector::slug('timezone'),
            'type' => 'general',
            'sort_order' => 0,
            'record_status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        expect_that($model->save());
    }

    public function testCreateNoDataMustFailed()
    {
        $model = new Setting([
            'record_status' => 1
        ]);
        expect_not($model->save());
    }

    public function testUpdateSuccess()
    {
        $model = Setting::findOne(1);
        $model->record_status = 0;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = Setting::findOne(1);
        expect_that($model->delete());
    }
}