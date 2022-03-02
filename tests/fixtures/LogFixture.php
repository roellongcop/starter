<?php

namespace app\tests\fixtures;

class LogFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Log';
    public $dataFile = '@app/tests/fixtures/data/models/log.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}