<?php

namespace tests\unit\models\form\setting;

use app\helpers\App;
use app\models\Setting;
use app\models\form\setting\SystemSettingForm;
use yii\helpers\ArrayHelper;

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
}