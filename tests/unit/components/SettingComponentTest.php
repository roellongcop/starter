<?php

namespace tests\unit\components;

use app\models\Setting;
use yii\helpers\ArrayHelper;

class SettingComponentTest extends \Codeception\Test\Unit
{
    public $setting;

    public function _before()
    {
        $this->setting = \Yii::$app->setting;
    }

    public function testAttributes()
    {
        expect(get_object_vars($this->setting))->equals(
            ArrayHelper::map(Setting::GENERAL, 'name', 'default')
        );
    }
}