<?php
namespace app\tests\unit\fixtures;

class UserFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\User';
    public $dataFile = '@app/tests/unit/fixtures/data/models/user.php';
    public $depends = ['app\tests\unit\fixtures\RoleFixture'];
}