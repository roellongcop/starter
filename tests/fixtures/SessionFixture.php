<?php

namespace app\tests\fixtures;

class SessionFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Session';
    public $dataFile = '@app/tests/fixtures/data/session.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}