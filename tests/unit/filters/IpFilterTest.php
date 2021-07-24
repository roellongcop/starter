<?php

namespace tests\unit\models;

use app\filters\IpFilter;
use app\helpers\App;
use app\models\Backup;
use app\models\Ip;
use app\models\form\SettingForm;

class IpFilterTest extends \Codeception\Test\Unit
{
    public function testValid()
    {
        $model = new IpFilter();

        expect_that($model->beforeAction(TRUE));

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
                $model->beforeAction(TRUE);
            }
        );
    }

    public function testWhitelist()
    {
        $setting = new \app\models\Setting([
            'name' => 'whitelist_ip_only',
            'value' => 1,
            'type' => 'general',
        ]);
        $setting->save();

        $this->tester->expectThrowable(
            new \yii\web\ForbiddenHttpException('IP not WhiteListed.'), 
            function() {
                $model = new IpFilter();
                $model->beforeAction(TRUE);
            }
        );
    }
}