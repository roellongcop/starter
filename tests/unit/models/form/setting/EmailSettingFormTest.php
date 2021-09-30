<?php

namespace tests\unit\models\form\setting;

use app\models\form\setting\EmailSettingForm;

class EmailSettingFormTest extends \Codeception\Test\Unit
{
    public function testValid()
    {
        $model = new EmailSettingForm();

        expect_that($model->save());

        $this->tester->seeRecord('app\models\Setting', [
            'name' => $model::NAME
        ]);
    }
}