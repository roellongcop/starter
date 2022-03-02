<?php

namespace app\tests\fixtures;

class SettingFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Setting';
    public $dataFile = '@app/tests/fixtures/data/setting.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}