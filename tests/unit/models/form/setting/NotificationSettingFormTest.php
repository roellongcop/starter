<?php

namespace tests\unit\models\form\setting;

use app\models\form\setting\NotificationSettingForm;

class NotificationSettingFormTest extends \Codeception\Test\Unit
{
    public function testValid()
    {
        $model = new NotificationSettingForm();

        expect_that($model->save());

        $this->tester->seeRecord('app\models\Setting', [
            'name' => $model::NAME
        ]);
    }
}