<?php
namespace app\tests\unit\fixtures;

class UserMetaFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\UserMeta';
    public $dataFile = '@app/tests/unit/fixtures/data/models/user-meta.php';
    public $depends = ['app\tests\unit\fixtures\UserFixture'];
}