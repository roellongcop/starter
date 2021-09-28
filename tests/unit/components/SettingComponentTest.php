<?php

namespace tests\unit\components;

use app\models\Setting;
use app\models\form\setting\EmailSettingForm;
use app\models\form\setting\ImageSettingForm;
use app\models\form\setting\NotificationSettingForm;
use app\models\form\setting\SystemSettingForm;
use yii\helpers\ArrayHelper;

class SettingComponentTest extends \Codeception\Test\Unit
{
    public $setting;

    public function _before()
    {
        $this->setting = \Yii::$app->setting;
    }

    public function testSystemSettingForm()
    {
        $model = new SystemSettingForm();
        expect(get_object_vars($this->setting->system))->equals($model->attributes);
    }

    public function testEmailSettingForm()
    {
        $model = new EmailSettingForm();
        expect(get_object_vars($this->setting->email))->equals($model->attributes);
    }

    public function testImageSettingForm()
    {
        $model = new ImageSettingForm();
        expect(get_object_vars($this->setting->image))->equals($model->attributes);
    }

    public function testNotificationSettingForm()
    {
        $model = new NotificationSettingForm();
        expect(get_object_vars($this->setting->notification))->equals($model->attributes);
    }
}