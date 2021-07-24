<?php

namespace tests\unit\models;

use app\filters\SettingFilter;
use app\helpers\App;

class SettingFilterTest extends \Codeception\Test\Unit
{
    public function testRejisterJs()
    {
        $model = new SettingFilter();
        expect_that($model->beforeAction(1));

        expect(\Yii::$app->view->js)->hasKey(\yii\web\View::POS_HEAD);
        expect(\Yii::$app->view->js[\yii\web\View::POS_HEAD])->hasKey('app');
    }

    public function testSetTimeout()
    {
        $model = new SettingFilter();
        expect_that($model->beforeAction(1));
        expect(App::session('timeout'))->equals(App::generalSetting('auto_logout_timer'));
    }
}