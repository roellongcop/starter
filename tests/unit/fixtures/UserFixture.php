<?php
namespace tests\unit\fixtures;

class UserFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\User';
    public $dataFile = '@tests/unit/fixtures/data/models/user.php';
    public $depends = ['tests\unit\fixtures\RoleFixture'];
}