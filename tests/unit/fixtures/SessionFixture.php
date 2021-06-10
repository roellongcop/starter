<?php
namespace app\tests\unit\fixtures;

class SessionFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Session';
    public $dataFile = '@app/tests/unit/fixtures/data/models/session.php';
    public $depends = ['app\tests\unit\fixtures\UserFixture'];
}