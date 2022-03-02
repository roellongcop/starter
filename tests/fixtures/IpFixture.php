<?php

namespace app\tests\fixtures;

class IpFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Ip';
    public $dataFile = '@app/tests/fixtures/data/ip.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}