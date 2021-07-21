<?php
namespace app\tests\fixtures;

class UserFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\User';
    public $dataFile = '@app/tests/fixtures/data/models/user.php';
    public $depends = ['app\tests\fixtures\RoleFixture'];
}