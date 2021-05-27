<?php
namespace tests\unit\fixtures;
use yii\test\ActiveFixture;

class RoleFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Role';
    public $dataFile = _DIR_ . 'data/role.php';
}