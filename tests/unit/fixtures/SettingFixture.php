<?php
namespace app\tests\unit\fixtures;

class SettingFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Setting';
    public $dataFile = '@app/tests/unit/fixtures/data/models/setting.php';
    public $depends = ['app\tests\unit\fixtures\UserFixture'];
}