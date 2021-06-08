<?php
namespace app\tests\unit\fixtures;

class LogFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Log';
    public $dataFile = '@app/tests/unit/fixtures/data/models/log.php';
    public $depends = ['app\tests\unit\fixtures\UserFixture'];
}