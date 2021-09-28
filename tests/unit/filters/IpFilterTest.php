<?php

namespace tests\unit\models;

use app\filters\IpFilter;
use app\helpers\App;
use app\models\Backup;
use app\models\Ip;
use app\models\form\setting\SystemSettingForm;

class IpFilterTest extends \Codeception\Test\Unit
{
    public function testValid()
    {
        $model = new IpFilter();

        expect_that($model->beforeAction(true));

        $this->tester->seeRecord('app\models\Ip', [
            'name' => App::ip(),
            'type' => Ip::TYPE_WHITELIST
        ]);
    }

    public function testBlacklist()
    {
        $condition = ['name' => App::ip()];
        $ip = Ip::findOne($condition) ?: new Ip($condition);
        $ip->type = Ip::TYPE_BLACKLIST;
        $ip->save();

        $this->tester->expectThrowable(
            new \yii\web\ForbiddenHttpException('IP is Blocked !'), 
            function() {
                $model = new IpFilter();
                $model->beforeAction(true);
            }
        );
    }

    public function testWhitelist()
    {
        $setting = new SystemSettingForm();
        $setting->whitelist_ip_only = 1;
        $setting->save();

        Ip::deleteAll(['name' => App::ip()]);

        $this->tester->seeRecord('app\models\Setting', [
            'name' => SystemSettingForm::NAME
        ]);

        $this->tester->expectThrowable(
            new \yii\web\ForbiddenHttpException('IP not WhiteListed.'), 
            function() {
                $model = new IpFilter();
                $model->beforeAction(true);
            }
        );
    }
}