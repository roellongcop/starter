<?php

namespace tests\unit\models\form\setting;

use app\models\form\setting\SystemSettingForm;

class SystemSettingFormTest extends \Codeception\Test\Unit
{
    public function testValid()
    {
        $model = new SystemSettingForm();

        expect_that($model->save());

        $this->tester->seeRecord('app\models\Setting', [
            'name' => $model::NAME
        ]);
    }

    public function testTimezoneInvalid()
    {
        $model = new SystemSettingForm();
        $model->timezone = 'invalid';
        expect_not($model->save());
        expect($model->errors)->hasKey('timezone');
    }

    public function testThemeInvalid()
    {
        $model = new SystemSettingForm();
        $model->theme = 456789;
        expect_not($model->save());
        expect($model->errors)->hasKey('theme');
    }

    public function testPaginationInvalid()
    {
        $model = new SystemSettingForm();
        $model->pagination = 456789;
        expect_not($model->save());
        expect($model->errors)->hasKey('pagination');
    }

    public function testWhitelistIpOnlyInvalid()
    {
        $model = new SystemSettingForm();
        $model->whitelist_ip_only = 456789;
        expect_not($model->save());
        expect($model->errors)->hasKey('whitelist_ip_only');
    }

    public function testEnableVisitorInvalid()
    {
        $model = new SystemSettingForm();
        $model->enable_visitor = 456789;
        expect_not($model->save());
        expect($model->errors)->hasKey('enable_visitor');
    }
}