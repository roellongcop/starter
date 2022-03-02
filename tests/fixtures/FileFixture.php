<?php

namespace app\tests\fixtures;

class FileFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\File';
    public $dataFile = '@app/tests/fixtures/data/file.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}