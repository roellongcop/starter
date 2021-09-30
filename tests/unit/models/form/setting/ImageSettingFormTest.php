<?php

namespace tests\unit\models\form\setting;

use app\models\form\setting\ImageSettingForm;

class ImageSettingFormTest extends \Codeception\Test\Unit
{
    public function testValid()
    {
        $model = new ImageSettingForm();

        expect_that($model->save());

        $this->tester->seeRecord('app\models\Setting', [
            'name' => $model::NAME
        ]);
    }
}