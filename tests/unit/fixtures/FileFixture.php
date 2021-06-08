<?php
namespace app\tests\unit\fixtures;

class FileFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\File';
    public $dataFile = '@app/tests/unit/fixtures/data/models/file.php';
    public $depends = ['app\tests\unit\fixtures\UserFixture'];
}