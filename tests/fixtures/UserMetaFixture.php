<?php

namespace app\tests\fixtures;

class UserMetaFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\UserMeta';
    public $dataFile = '@app/tests/fixtures/data/user-meta.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}