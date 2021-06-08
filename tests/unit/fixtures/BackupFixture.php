<?php
namespace app\tests\unit\fixtures;

class BackupFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Backup';
    public $dataFile = '@app/tests/unit/fixtures/data/models/backup.php';
    public $depends = ['app\tests\unit\fixtures\UserFixture'];
}