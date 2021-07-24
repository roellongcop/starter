<?php

namespace tests\unit\models\form\setting;

use app\helpers\App;
use app\models\Setting;
use app\models\form\setting\GeneralSettingForm;
use yii\helpers\ArrayHelper;

class GeneralSettingFormTest extends \Codeception\Test\Unit
{
    private function data()
    {
        $data = ArrayHelper::map(Setting::GENERAL, 'name', 'default');

        return $data;
    }

    public function testValid()
    {
        $model = new GeneralSettingForm();

        expect_that($model->save());

        $this->tester->seeRecord('app\models\Setting', [
            'name' => 'general-setting'
        ]);
    }
}